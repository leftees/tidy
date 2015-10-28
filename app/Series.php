<?php

namespace Tidy;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';

    protected $fillable = ['title', 'description', 'for_dvd', 'for_bluray', 'for_book'];

    public function scopeForDvd($query)
    {
        return $query->where('for_dvd', true);
    }

    public function scopeForBluray($query)
    {
        return $query->where('for_bluray', true);
    }

    public function scopeForBook($query)
    {
        return $query->where('for_book', true);
    }
}
