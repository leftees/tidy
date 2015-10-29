<?php

namespace Tidy;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';

    protected $fillable = ['title', 'description', 'for_dvd', 'for_bluray', 'for_book', 'account_id'];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blurays()
    {
        return $this->hasMany('Tidy\Bluray');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('Tidy\Account');
    }
}
