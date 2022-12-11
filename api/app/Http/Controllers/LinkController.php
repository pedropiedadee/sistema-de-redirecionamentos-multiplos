<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function listagem(Request $request)
    {
        $listLink = Link::all();
        return response()->json($listLink);
    }
}
