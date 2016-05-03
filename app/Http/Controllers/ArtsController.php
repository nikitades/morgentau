<?php

namespace App\Http\Controllers;

use App\Art;
use App\Http\Requests\CreateArtRequest;
use App\Page;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class ArtsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arts = Art::indexList()->get();
        $page = Page::where('url', '=',  '/')->first();
        return view('pages.homePage', compact('arts', 'page'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $item = NewsItem::where('newsitem_url', $url)->firstOrFail();
        return view('pages.newsItem', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateArtRequest $request)
    {
        $item = new Art($request->all());
        $item->save();
        ImagesController::saveImages($request, $item);
        Session::flash('success-message', Lang::get('global.successfully-saved'));
        return clever_redirect($request, '/admin/arts');
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
        $item = Art::findOrFail($id);
        $item->fill($request->all())->save();
        ImagesController::saveImages($request, $item);
        Session::flash('success-message', Lang::get('global.successfully-saved'));
        return clever_redirect($request, '/admin/arts/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Art::findOrFail($id);
        $item->delete();
        return redirect('/admin/arts');
    }
}
