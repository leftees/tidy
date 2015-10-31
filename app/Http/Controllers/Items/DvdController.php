<?php

namespace Tidy\Http\Controllers\Items;

use Illuminate\Http\Request;
use Tidy\Dvd;
use Tidy\Http\Requests;
use Tidy\Http\Controllers\Controller;
use Tidy\Http\Requests\Items\DvdRequest;

class DvdController extends AbstractVidController
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->globalIndex($request);
    }

    /**
     * @param DvdRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DvdRequest $request)
    {
        $dvd = $this->globalStore($request);

        return response()->json(compact('dvd'));
    }


    /**
     * @param Dvd $dvd
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Dvd $dvd)
    {
        $dvd = $this->globalShow($dvd);

        return response()->json(compact('dvd'));
    }

    /**
     * @param DvdRequest $request
     * @param Dvd $dvd
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DvdRequest $request, Dvd $dvd)
    {
        $dvd = $this->globalUpdate($request, $dvd);

        return response()->json(compact('dvd'));
    }

    /**
     * @param Dvd $dvd
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Dvd $dvd)
    {
        $deleted = $this->globalDestroy($dvd);

        return response()->json(compact('deleted'));
    }
}
