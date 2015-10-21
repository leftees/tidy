<?php

namespace Tidy\Http\Controllers;

use Illuminate\Http\Request;
use Tidy\Http\Requests;
use Tidy\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;


class AuthenticationController extends Controller
{

    public function touch()
    {

    }

    /**
     * Authenticate the user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $token = JWTAuth::attempt($credentials);

            if (!$token) {
                return $this->respondError(401, 'invalid_credentials');
            }

        } catch (JWTException $ex) {
            return $this->respondError(500, 'could_not_create_token');
        }

        return response()->json(compact('token'));
    }

    /**
     * Attempts to invalidate the current token
     * @return \Illuminate\Http\JsonResponse
     */
    public function invalidate()
    {
        try {
            JWTAuth::invalidate();
        } catch (JWTException $e) {
        }
        return response()->json(['success' => true]);
    }

    public function getActiveUser()
    {
        $user = $this->getUser();
        if(!$user instanceof User) {
            return $user;
        }

        return response()->json(compact('user'));
    }

}
