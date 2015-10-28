<?php

namespace Tidy;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
    
    protected $fillable = ['name', 'description', 'for_dvd', 'for_bluray'];
    
    
}
