<?php

namespace Tidy\Http\Controllers\Items;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Response;
use Tidy\AbstractVid;
use Tidy\Http\Requests;
use Tidy\Http\Controllers\Controller;
use Tidy\Http\Requests\Items\AbstractVidRequest;

/**
 * Base controller to handle the differences between Blurays and DVDs (since they're almost identical)
 * 
 * Class AbstractVidController
 * @package Tidy\Http\Controllers\Items
 */
class AbstractVidController extends Controller
{
    /**
     * @var AbstractVid
     */
    protected $model;

    public function __construct(AbstractVid $model)
    {
        $this->model = $model;
    }

    /**
     * Call a method on the model
     * @param $method
     * @param ...$args
     *
     * @return mixed
     */
    private function callModel($method, ...$args) {
        return forward_static_call_array([$this->model, $method], $args);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function globalIndex(Request $request)
    {
        /** @var \Illuminate\Database\Eloquent\Collection $itemsCollection */
        $itemsCollection = $this->callModel('whereIn', 'account_id', $this->getAccountIds());

        $count = $itemsCollection->count();
        $perPage = static::PER_PAGE;
        $currentPage = $request->get('page', 1);

        $blurays = $itemsCollection->forPage($currentPage, static::PER_PAGE);

        return response()->json(compact('blurays', 'count', 'perPage', 'currentPage'));
    }

    /**
     * @param AbstractVidRequest $request
     *
     * @return mixed
     */
    protected function globalStore(AbstractVidRequest $request)
    {
        return $this->callModel('create', $request->all());
    }

    /**
     * @param AbstractVid $model
     *
     * @return AbstractVid
     */
    protected function globalShow(AbstractVid $model)
    {
        $this->assertModelIsValid($model);

        return $model;
    }

    /**
     * @param AbstractVidRequest $request
     * @param AbstractVid $model
     *
     * @return AbstractVid
     */
    protected function globalUpdate(AbstractVidRequest $request, AbstractVid $model)
    {
        $this->assertModelIsValid($model);

        $model->save();

        return $model;
    }

    /**
     * @param AbstractVid $model
     *
     * @return AbstractVid
     * @throws \Exception
     */
    protected function globalDestroy(AbstractVid $model)
    {
        $this->assertModelIsValid($model);

        return $model->delete();
    }

    /**
     * @param AbstractVid $model
     */
    private function assertModelIsValid(AbstractVid $model)
    {
        if (!in_array($model->account->id, $this->getAccountIds())) {
            throw new ModelNotFoundException;
        }
    }
}
