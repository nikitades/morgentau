<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\View;

class ViewsController extends Controller
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
        $val = $this->validate($request, View::$validation);
        if ($val->fails()) {
            return redirect()->back()->withErrors($val);
        }
        
        $item = new View($request->all());
        $items = View::all();
        $item->pos = sizeof($items) + 1;
        $item->save();
        return $this->cleverRedirect($request, '/admin/views');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $val = $this->validate($request, View::$validation);
        if ($val->fails()) {
            return redirect()->back()->withErrors($val);
        }

        $item = View::findOrFail($id);
        $item->fill($request->all())->save();
        return $this->cleverRedirect($request, '/admin/views');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = View::findOrFail($id);
        $item->delete();
        return redirect('/admin/views');
    }

    /**
     * Returns the list of the available page views.
     *
     * @return array
     */
    public static function views()
    {
        $views = [];
        foreach(View::adminList()->get() as $view) {
            $views[$view['id']] = $view['name'];
        }
        return $views;
    }
}
