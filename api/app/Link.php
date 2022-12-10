<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    protected $fillable = [
        'link', 'max_click', 'click'
    ];

    public function redirect(): BelongsTo
    {
        return $this->belongsTo(Redirect::class);
    }
}
