<?php

namespace Tidy\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Tidy\Http\Requests;
use Tidy\Http\Controllers\Controller;
use Tidy\Rating;

class RatingsController extends Controller
{

    /**
     * @var Rating
     */
    protected $rating;

    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }

    /**
     * Call a method on the model
     * @param $method
     * @param ...$args
     *
     * @return mixed
     */
    private function callModel($method, ...$args) {
        return forward_static_call_array([$this->rating, $method], $args);
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
        
        // Do some more filtering
        if($request->get('dvd')) {
            $itemsCollection->where('for_dvd', true);
        }
        if($request->get('bluray')) {
            $itemsCollection->where('for_bluray', true);
        }
        
        $count = $itemsCollection->count();
        $perPage = static::PER_PAGE;
        $currentPage = $request->get('page', 1);
        
        
        $ratings = $itemsCollection->forPage($currentPage, static::PER_PAGE);

        return response()->json(compact('ratings', 'count', 'perPage', 'currentPage'));
    }
    

    /**
     * @param Rating $rating
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Rating $rating)
    {
        return response()->json(compact('rating'));
    }

}
