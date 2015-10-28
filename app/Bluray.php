<?php

namespace Tidy;

use Illuminate\Database\Eloquent\Model;

class Bluray extends Model
{
    protected $table = 'blurays';
    
    protected $fillable = ['title', 'description', 'series', 'rating', 'account'];
    
    
}
