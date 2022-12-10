<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $fillable = [
        'nome_link', 'link_hash', 'total_max_click',
    ];
}
