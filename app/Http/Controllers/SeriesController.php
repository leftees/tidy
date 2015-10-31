<?php

namespace Tidy\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Tidy\Http\Requests;
use Tidy\Http\Controllers\Controller;
use Tidy\Series;

class SeriesController extends Controller
{

    /**
     * @var Series
     */
    protected $series;

    public function __construct(Series $series)
    {
        $this->series = $series;
    }

    /**
     * Call a method on the model
     * @param $method
     * @param ...$args
     *
     * @return mixed
     */
    private function callModel($method, ...$args) {
        return forward_static_call_array([$this->series, $method], $args);
    }
    
    private function assertSeriesIsValid(Series $series)
    {
        if (!in_array($series->account->id, $this->getAccountIds())) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        /** @var \Illuminate\Database\Eloquent\Collection $itemsCollection */
        $itemsCollection = $this->callModel('whereIn', 'account_id', $this->getAccountIds());

        $count = $itemsCollection->count();
        $perPage = static::PER_PAGE;
        $currentPage = $request->get('page', 1);

        $series = $itemsCollection->forPage($currentPage, static::PER_PAGE);

        return response()->json(compact('series', 'count', 'perPage', 'currentPage'));
    }

    /**
     * @param Requests\SeriesRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Requests\SeriesRequest $request)
    {
        $series = $this->series->create($request->all());
        return response()->json(compact('series'));
    }

    /**
     * @param Series $series
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Series $series)
    {
        $this->assertSeriesIsValid($series);
        
        return response()->json(compact('series'));
    }


    /**
     * @param Requests\SeriesRequest $request
     * @param Series $series
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Requests\SeriesRequest $request, Series $series)
    {
        $this->assertSeriesIsValid($series);
        $series->fill($request->except(['account_id']));
        
        $series->save();
        
        return response()->json(compact('series'));
    }

    /**
     * @param Series $series
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Series $series)
    {
        $this->assertSeriesIsValid($series);
        
        $deleted = $series->delete();
        
        return response()->json(compact('deleted'));
    }
}
