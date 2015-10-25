<?php

namespace Tidy\Http\Controllers;

use Illuminate\Http\Request;
use Tidy\Http\Requests;
use Tidy\User;

class UserController extends Controller
{
    public function getActiveUser()
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $user;
        }

        return response()->json(compact('user'));
    }

   
    /**
     * @return null|User
     */
    protected function user()
    {
        $user = parent::getUser(false);
        return $user instanceof User ? $user : null;
    }
}
