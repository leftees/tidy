<?php

namespace Tidy\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use JWTAuth;
use Tidy\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const PER_PAGE = 20;

    /**
     * @param User
     */
    private $user;

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
        
        return response()->json($response, $code);
    }

    /**
     * @param bool $jsonOnError
     * @return \Illuminate\Http\JsonResponse|mixed|null|User
     */
    protected function getUser($jsonOnError = false)
    {
        if($this->user instanceof User) {
            return $this->user;
        }

        $error = false;
        $statusCode = 404;
        $message = '';
        $user = null;
        
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if(!$user) {
                $error = true;
                $statusCode = 401;
                $message = 'token_absent';
            }
        }
        catch (TokenExpiredException $ex) {
            $error = true;
            $statusCode = 401;
            $message = 'token_expired';
        }
        catch (TokenInvalidException $ex) {
            $error = true;
            $statusCode = 401;
            $message = 'token_invalid';
        }
        catch (JWTException $ex) {
            $error = true;
            $statusCode = 401;
            $message = 'token_absent';
        }
        
        if($error) {
            return $jsonOnError ? response()->json(['error' => $message], $statusCode) : null;
        }
        
        $this->user = $user;
        return $this->user;
    }

    /**
     * Returns the active accountIds for this user
     * @return array
     */
    public function getAccountIds()
    {
        $user = $this->getUser(false);

        if(!$user) {
            return [];
        }

        return $user->accounts()->pluck(['account_id'])->all();
    }
}
