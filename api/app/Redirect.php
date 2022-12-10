<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Redirect extends Model
{
    protected $fillable = [
        'nome_link', 'link_hash', 'total_max_click',
    ];

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }
}
