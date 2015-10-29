<?php

namespace Tidy;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
    
    protected $fillable = ['name', 'description', 'for_dvd', 'for_bluray'];


    public function scopeForDvd($query)
    {
        return $query->where('for_dvd', true);
    }

    public function scopeForBluray($query)
    {
        return $query->where('for_bluray', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blurays()
    {
        return $this->hasMany('Tidy\Bluray');
    }
    
}
