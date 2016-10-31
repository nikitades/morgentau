<?php

namespace App\Http\Controllers;

use App\Hierarchy;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\FilesController;
use App\Page;
use App\View;
use App\Text;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{

    public static $url_stack = [];
    public static $async = [
        'dropSort' => []
    ];

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
        $ancestor = Page::findOrFail($item->parent_id);
        $item->real_level = $ancestor->real_level + 1;
        $pages = Page::where('parent_id', $item->parent_id)->get();
        $item->pos = sizeof($pages) + 1;
        $item->full_url = $item->createUrl();
        $item->save();
        $this->reorderItems(Page::where('parent_id', $item->parent_id)->orderBy('pos')->get());
        ImagesController::saveImages($request, $item);
        FilesController::saveFiles($request, $item);
        return clever_redirect($request, '/admin/pages');
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
        //grabbing the initial data
        $item = Page::findOrFail($id);
        $oldParent = $item->parent_id;
        $oldUrl = $item->url;
        $item->fill($request->all());

        if ($item->parent_id != $oldParent) {
            //checking if there's need to move the orphaned page one level up
            $newParent = Page::find($item->parent_id);
            $descendants = [];
            $item->findDescendantsFlat($descendants);

            usort($descendants, function ($a, $b) {
                if ($a->real_level == $b->real_level) {
                    if ($a->pos == $b->pos) {
                        $a->pos = 9999;
                        return -1;
                    }
                    return $a->pos > $b->pos ? 1 : -1;
                }
                return $a->real_level > $b->real_level ? 1 : -1;
            });

            foreach ($descendants as $d) {
                if ($d->id == $newParent->id) {
                    $newLeader = reset($descendants);
                    $newLeader->parent_id = $oldParent;
                    $newLeader->save();
                    break;
                }
            }

            foreach ($descendants as $d) {
                $d->real_level = (Page::find($d->parent_id)->real_level + 1);
                $d->full_url = $d->createUrl();
                $d->save();
            }

            //reordering items to keep order
            $this->reorderItems(Page::where('parent_id', $oldParent)->orderBy('pos')->get());
        }

        $item->real_level = Page::findOrFail($item->parent_id)->real_level + 1;

        if ($item->parent_id != $oldParent) {
            $pages = Page::where('parent_id', $item->parent_id)->get();
            $item->pos = sizeof($pages) + 1;
        }
        $item->full_url = $item->createUrl();
        $item->save();

        //just update links of all the siblings in case of the url change
        if ($item->url != $oldUrl) {
            $descendants = [];
            $item->findDescendantsFlat($descendants);

            foreach ($descendants as $d) {
                $d->full_url = $d->createUrl();
                $d->save();
            }
        }

        if ($item->parent_id != $oldParent) $this->reorderItems(Page::where('parent_id', $item->parent_id)->orderBy('pos')->get());
        ImagesController::saveImages($request, $item);
        FilesController::saveFiles($request, $item);
        Session::flash('success-message', Lang::get('global.successfully-saved'));
        return clever_redirect($request, '/admin/pages');
    }

    /**
     * Display the home page.
     *
     * @param string $url
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function home()
    {
        $page = Page::where('url', '/')->where('is_active', 1)->firstOrFail();
        $view = View::findOrFail($page->view);
        return view($view->view, compact('page'));
    }

    /**
     * Display the specified resource.
     *
     * @param string $url
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($url)
    {
        $url = explode('/', $url);
        $homePage = Page::where('real_level', '0')->where('is_active', 1)->firstOrFail();
        self::$url_stack[$homePage->id] = $homePage;
        $parent_id = $homePage->id;
        foreach ($url as $url_block) {
            $soughtPage = Page::where('url', $url_block)->where('parent_id', $parent_id)->where('is_active', true)->first();
            if ($soughtPage) {
                $parent_id = $soughtPage->id;
                self::$url_stack[$soughtPage->id] = $soughtPage;
            } else {
                self::$url_stack['error'] = '404';
                break;
            }
        }
        if (empty(self::$url_stack)) abort(404);
        $page = end(self::$url_stack);
        if ($page == '404') return response()->view('pages.404', [], 404);
        $view = View::find($page->view);
        $breadcrumbs = self::$url_stack;
        return view($view->view, compact('page', 'breadcrumbs'));
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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Page::findOrFail($id);
        $imageEntities = Page::images();

        //destroy linked images
        if (sizeof($imageEntities)) {
            foreach ($imageEntities as $imageEntity) {
                $className = 'App\\'.$imageEntity;
                $imageEntityItems = $className::where('parent_id', $item->id)->get();
                if (sizeof($imageEntityItems)) {
                    foreach ($imageEntityItems as $entityItem) {
                        ImagesController::deleteImage($entityItem->image_id);
                        $entityItem->delete();
                    }
                }
            }
        }

        //destroy linked files
        $fileEntities = Page::files();
        if (sizeof($fileEntities)) {
            foreach ($fileEntities as $fileEntity) {
                $className = 'App\\'.$fileEntity;
                $fileEntityItems = $className::where('parent_id', $item->id)->get();
                if (sizeof($fileEntityItems)) {
                    foreach ($fileEntityItems as $entityItem) {
                        FilesController::deleteFile($entityItem->file_id);
                        $entityItem->delete();
                    }
                }
            }
        }

        //destroy itself
        self::searchAndDestroy($item);
        $this->reorderItems(Page::where('parent_id', $item->parent_id)->orderBy('pos')->get());
        return redirect('/admin/pages');
    }

    /**
     * Service function to delete recursively the page with all the siblings.
     *
     * @param $page
     */
    public static function searchAndDestroy($page)
    {
        $children = Page::where('parent_id', $page->id)->get();
        if (sizeof($children)) {
            foreach ($children as $child) {
                self::searchAndDestroy($child);
            }
        }
        $page->delete();
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
            $existing = Page::where('pos', $item->pos - 1)->where('parent_id', $item->parent_id)->first();
            if ($existing) {
                if ($item->pos > 1) {
                    $item->pos = $item->pos - 1;
                    $item->save();
                    $existing->pos = $existing->pos + 1;
                    $existing->save();
                    $this->reorderItems(Page::where('parent_id', $item->parent_id)->orderBy('pos')->get());
                }
            }
        } elseif ($direction == 'down') {
            $existing = Page::where('pos', $item->pos + 1)->where('parent_id', $item->parent_id)->first();
            if ($existing) {
                if ($item->pos < sizeof($items)) {
                    $item->pos = $item->pos + 1;
                    $item->save();
                    $existing->pos = $existing->pos - 1;
                    $existing->save();
                    $this->reorderItems(Page::where('parent_id', $item->parent_id)->orderBy('pos')->get());
                }
            }
        }
        return redirect('/admin/pages');
    }

    public static function dropSort($json_data)
    {
        //валидация
        $validation = validate_true_with_message([
            [
                'check' => isset($json_data['order']),
                'message' => 'Не передан ордер!'
            ],
        ]);
        if ($validation !== true) return error($validation);
        if (!Auth::user()->admin) return error('Доступ запрещен');

        //заполняем список
        $ids = [];
        foreach ($json_data['order'] as $item) {
            if (is_array($item)) {
                $ids[] = $item['id'];
            }
        }
//        if (sizeof($roots) != 1) error('Неверное количество корневых страниц!');

        //проходим переназначением данных
        $pages = Page::whereIn('id', $ids)->get();
        foreach ($pages as $page) {
            $page->pos = $json_data['order'][$page->id]['n'];
            if (isset($json_data['order'][$page->id]['parent'])) {
                $page->parent_id = $json_data['order'][$page->id]['parent'];
            }
            $page->save();
        }
        self::recountData();
        ah(view('partials.treepage', ['tree' => Page::tree()]));
        return true;
    }

    public static function recountData()
    {
        $pages = Page::all();
        foreach ($pages as $page) {
            $real_level = -1;
            $searching_page = $page;
            while ($parent = Page::where('id', $searching_page->parent_id)->first()) {
                $real_level++;
                $searching_page = $parent;
            }
            $page->real_level = $real_level;
            $page->save();
        }
    }

    /**
     * Returns the pages hierarchy entity. Easy to control the display of the parent_ids list.
     *
     * @return Hierarchy
     */
    public static function hierarchy()
    {
        $hierarchy = new Hierarchy();
        $trueRoot = Page::firstOrCreate(['is_root' => 1, 'real_level' => -1, 'name' => Page::ROOT_PAGE_NAME, 'url' => '']);
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
