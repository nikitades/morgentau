<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Text;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TextsController extends Controller
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
        $item = new Text($request->all());
        $items = Text::all();
        $item->pos = sizeof($items) + 1;
        $item->save();
        return $this->cleverRedirect($request, '/admin/texts');
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
        $item = Text::findOrFail($id);
        $item->fill($request->all())->save();
        return $this->cleverRedirect($request, '/admin/texts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Text::findOrFail($id);
        $item->delete();
        $this->reorderItems(Text::orderBy('pos')->get());
        return redirect('/admin/texts');
    }


    /**
     * Moving the text amongst the siblings according to the incoming data.
     *
     * @param $id
     * @param $direction
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function move($id, $direction)
    {
        $items = Text::all();
        $item = Text::findOrFail($id);
        if ($direction == 'up') {
            $existing = Text::where('pos', $item->pos - 1)->first();
            if ($existing) {
                $existing->pos = $existing->pos + 1;
                $existing->save();
            }
            if ($item->pos > 1) {
                $item->pos = $item->pos - 1;
                $item->save();
            }
        }
        elseif ($direction == 'down') {
            $existing = Text::where('pos', $item->pos + 1)->first();
            if ($existing) {
                $existing->pos = $existing->pos - 1;
                $existing->save();
            }
            if ($item->pos < sizeof($items)) {
                $item->pos = $item->pos + 1;
                $item->save();
            }
        }
        return redirect('/admin/texts');
    }
}
