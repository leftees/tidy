<?php

namespace Tidy\Http\Controllers\Items;

use Illuminate\Http\Request;
use Tidy\Bluray;
use Tidy\Http\Requests;
use Tidy\Http\Controllers\Controller;
use Tidy\Http\Requests\Items\BlurayRequest;

class BlurayController extends AbstractVidController
{
    public function __construct(Bluray $bluray) {
        parent::__construct($bluray);
    }

    /**
     * @param Request $request
     *
     * @return \Response
     */
    public function index(Request $request)
    {
        return $this->globalIndex($request);
    }

    /**
     * @param BlurayRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BlurayRequest $request)
    {
        $bluray = $this->globalStore($request);
        
        return response()->json(compact('bluray'));
    }

    /**
     * @param Bluray $bluray
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Bluray $bluray)
    {
        $bluray = $this->globalShow($bluray);

        return response()->json(compact('bluray'));
    }

    /**
     * @param BlurayRequest $request
     * @param Bluray $bluray
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BlurayRequest $request, Bluray $bluray)
    {
        $bluray = $this->globalUpdate($request, $bluray);

        return response()->json(compact('bluray'));
    }

    /**
     * @param Bluray $bluray
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Bluray $bluray)
    {
        $deleted = $this->globalDestroy($bluray);

        return response()->json(compact('deleted'));
    }
}
