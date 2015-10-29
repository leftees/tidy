<?php

namespace Tidy\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Tidy\User;

abstract class Request extends FormRequest
{

    /**
     * @return array
     */
    protected function getUserAccountIds()
    {
        /** @var User $user */
        $user = $this->user();
        return $user->getAccountIds();
    }
    
}
