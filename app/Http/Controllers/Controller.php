<?php

namespace Tidy\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Respond with a error
     * @param int $code The HTTP error code to use
     * @param string $message The message to return
     * @param array|null $extra Any extra responses to return
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondError($code, $message, array $extra = null)
    {
        $response = [
            'error' => $message
        ];

        if (is_array($extra)) {
            $response = array_merge($response, $extra);
        }
        
        dd($response);
        
        return response()->json($response, $code);
    }
    
}
