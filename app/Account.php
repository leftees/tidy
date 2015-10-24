<?php

namespace Tidy;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
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

    /**
     * The users that belong to the account
     */
    public function users()
    {
        return $this->belongsToMany('Tidy\User');
    }

}
