<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\NewsItem;
use App\Http\Requests;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new NewsItem($request->all());
        $item->save();
        ImagesController::saveImages($request, $item);
        Session::flash('success-message', Lang::get('global.successfully-saved'));
        return clever_redirect($request, '/admin/news');
    }

    /**
     * Display the specified resource.
     *
     * @param $url
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($url)
    {
        $item = $page = NewsItem::where('newsitem_url', $url)->firstOrFail();
        $page->name = $page->title;
        return view('pages.newsItem', compact('item', 'page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = NewsItem::findOrFail($id);
        $item->fill($request->all())->save();
        ImagesController::saveImages($request, $item);
        Session::flash('success-message', Lang::get('global.successfully-saved'));
        return clever_redirect($request, '/admin/news');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = NewsItem::findOrFail($id);
        $item->delete();
        return redirect('/admin/news');
    }

    /**
     * Inverts the value of the 'hot' field of the given newsitem.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function makeHot($id)
    {
        $item = NewsItem::findOrFail($id);
        if ($item->hot) {
            $item->hot = false;
        } else {
            $item->hot = true;
        }
        $item->save();
        return redirect('/admin/news');
    }
}
