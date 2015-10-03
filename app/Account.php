<?php

namespace Tidy;

use Illuminate\Database\Eloquent\Model;

class Account extends Mode
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'description'];

}
