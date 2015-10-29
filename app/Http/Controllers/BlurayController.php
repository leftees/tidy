<?php

namespace Tidy\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tidy\Bluray;
use Tidy\Http\Requests;
use Tidy\Http\Requests\BlurayRequest;

class BlurayController extends Controller
{

    /**
     * @var Bluray
     */
    protected $bluray;

    public function __construct(Bluray $bluray)
    {
        $this->bluray = $bluray;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
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
     * @param BlurayRequest $request
     *
     * @return Response
     */
    public function store(BlurayRequest $request)
    {
        $bluray = $this->bluray->create($request->only(['title', 'description', 'account_id']));

        return response()->json(compact('bluray'));
    }

    /**
     * Display the specified resource.
     *
     * @param Bluray $bluray
     *
     * @return Response
     */
    public function show(Bluray $bluray)
    {
        if (!in_array($bluray->account->id, $this->getAccountIds())) {
            throw new ModelNotFoundException;
        }

        return response()->json(compact('bluray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlurayRequest $request
     * @param Bluray $bluray
     *
     * @return Response
     */
    public function update(BlurayRequest $request, Bluray $bluray)
    {
        if (!in_array($bluray->account->id, $this->getAccountIds())) {
            throw new ModelNotFoundException;
        }

        $bluray->save();

        return response()->json(compact('bluray'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Bluray $bluray
     *
     * @return Response
     * @throws \Exception
     */
    public function destroy(Bluray $bluray)
    {
        if (!in_array($bluray->account->id, $this->getAccountIds())) {
            throw new ModelNotFoundException;
        }

        $bluray->delete();

        return response()->json(['message' => 'deleted']);
    }
}
