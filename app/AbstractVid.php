<?php

namespace Tidy;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Account account
 * @property Rating rating
 * @property Series series
 */
class AbstractVid extends Model
{
    protected $fillable = ['title', 'description', 'series_id', 'rating_id', 'account_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function series()
    {
        return $this->belongsTo('Tidy\Series');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function rating()
    {
        return $this->belongsTo('Tidy\Rating');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function account()
    {
        return $this->belongsTo('Tidy\Account');
    }
}
