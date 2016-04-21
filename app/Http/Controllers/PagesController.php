<?php

namespace App\Http\Controllers;

use App\Hierarchy;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\FilesController;
use App\Page;
use App\PageTree;
use App\View;
use App\Text;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        die('here');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.entities.edit.pages', ['title' => 'Страницы', 'item' => new Page]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Page($request->all());
        $ancestor = Page::findOrFail($item->parent);
        $item->real_level = $ancestor->real_level + 1;
        $pages = Page::where('parent', $item->parent)->get();
        $item->pos = sizeof($pages) + 1;
        $item->save();
        $this->reorderItems(Page::where('parent', $item->parent)->orderBy('pos')->get());
        $siblings = PageTree::where('ancestor', $item->parent)->get();
        $pageTree = new PageTree(['ancestor' => $item->parent, 'descendant' => $item->id, 'depth' => $ancestor->real_level + 1, 'pos' => sizeof($siblings) + 1]);
        $pageTree->save();
        ImagesController::saveImages($request, $item);
        FilesController::saveFiles($request, $item);
        return clever_redirect($request, '/admin/pages');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($url = '/')
    {
        $page = Page::where('url', $url)->where('is_active', 1)->firstOrFail();
        $view = View::findOrFail($page->view);
        return view($view->view, compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Page::findOrFail($id);
        $oldParent = $item->parent;
        $item->fill($request->all());
        if ($item->parent != $oldParent) {
            $this->reorderItems(Page::where('parent', $oldParent)->orderBy('pos')->get());
        }
        $item->real_level = Page::findOrFail($item->parent)->real_level + 1;
        if ($item->parent != $oldParent) $pages = Page::where('parent', $item->parent)->get();
        if ($item->parent != $oldParent) $item->pos = sizeof($pages) + 1;
        $item->save();
        if ($item->parent != $oldParent) $this->reorderItems(Page::where('parent', $item->parent)->orderBy('pos')->get());
        ImagesController::saveImages($request, $item);
        FilesController::saveFiles($request, $item);
        Session::flash('success-message', Lang::get('global.successfully-saved'));
        return clever_redirect($request, '/admin/pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Page::findOrFail($id);
        self::searchAndDestroy($item);
        $this->reorderItems(Page::where('parent', $item->parent)->orderBy('pos')->get());
        return redirect('/admin/pages');
    }

    /**
     * Service function to delete recursively the page with all the siblings.
     *
     * @param $page
     */
    public static function searchAndDestroy($page)
    {
        $children = Page::where('parent', $page->id)->get();
        if (sizeof($children)) {
            foreach($children as $child) {
                self::searchAndDestroy($child);
            }
        }
        $page->delete();
        $pageTree = PageTree::where('descendant', $page->id);
        $pageTree->delete();
    }

    /**
     * Moving the page amongst the siblings according to the incoming data.
     *
     * @param $id
     * @param $direction
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function move($id, $direction)
    {
        $items = Page::all();
        $item = Page::findOrFail($id);
        if ($direction == 'up') {
            $existing = Page::where('pos', $item->pos - 1)->where('parent', $item->parent)->first();
            if ($existing) {
                if ($item->pos > 1) {
                    $item->pos = $item->pos - 1;
                    $item->save();
                    $existing->pos = $existing->pos + 1;
                    $existing->save();
                    $this->reorderItems(Page::where('parent', $item->parent)->orderBy('pos')->get());
                }
            }
        } elseif ($direction == 'down') {
            $existing = Page::where('pos', $item->pos + 1)->where('parent', $item->parent)->first();
            if ($existing) {
                if ($item->pos < sizeof($items)) {
                    $item->pos = $item->pos + 1;
                    $item->save();
                    $existing->pos = $existing->pos - 1;
                    $existing->save();
                    $this->reorderItems(Page::where('parent', $item->parent)->orderBy('pos')->get());
                }
            }
        }
        return redirect('/admin/pages');
    }

    /**
     * Returns the pages hierarchy entity. Easy to control the display of the parents list.
     *
     * @return Hierarchy
     */
    public static function hierarchy()
    {
        $hierarchy = new Hierarchy();
        $trueRoot = Page::firstOrCreate(['is_root' => 1, 'real_level' => -1, 'name' => Page::ROOT_PAGE_NAME, 'url' => '']);
        $rootPage = PageTree::where('ancestor', $trueRoot->id)->first();
        $hierarchy->root = ['name' => $trueRoot->name, 'id' => $trueRoot->id];
        $hierarchy->pages = [];
        $list = [];
        foreach (Page::flatTree() as $page) {
            $list[$page->id] = $page->name;
        }
        $hierarchy->pages = $list;
        return $hierarchy;
    }
}
