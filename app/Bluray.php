<?php

namespace Tidy;

use Illuminate\Database\Eloquent\Model;

class Bluray extends Model
{
    protected $table = 'blurays';
    
    protected $fillable = ['title', 'description', 'series_id', 'rating_id', 'account_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function series() {
        return $this->belongsTo('Tidy\Series');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function rating() {
        return $this->belongsTo('Tidy\Rating');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function account() {
        return $this->belongsTo('Tidy\Account');
    }
    
    
}
