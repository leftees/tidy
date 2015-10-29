<?php

namespace Tidy\Http\Controllers;

use Illuminate\Http\Request;
use Tidy\Bluray;
use Tidy\Http\Requests;
use Tidy\Http\Controllers\Controller;

class BlurayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bluraysCollection = Bluray::whereIn('account_id', $this->getAccountIds());

        $count = $bluraysCollection->count();
        $perPage = static::PER_PAGE;
        $currentPage = $request->get('page', 1);

        $blurays = $bluraysCollection->forPage($currentPage, static::PER_PAGE)->get();

        return response()->json(compact('blurays', 'count', 'perPage', 'currentPage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\BlurayRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\BlurayRequest $request)
    {
//        $request->
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
     * @param Requests\BlurayRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\BlurayRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
