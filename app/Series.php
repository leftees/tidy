<?php

namespace Tidy;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';
    
    protected $fillable = ['title', 'description', 'for_dvd', 'for_bluray', 'for_book'];
}
