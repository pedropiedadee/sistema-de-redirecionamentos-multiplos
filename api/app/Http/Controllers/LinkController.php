<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkUpdateRequest;
use App\Http\Resources\LinkResource;
use App\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function listagem(Request $request)
    {
        $listLink = Link::all();
        return response()->json($listLink);
    }

    public function update(Link $link, LinkUpdateRequest $request)
    {
        $input = $request->validated();

        $link->fill($input);
        $link->save();

        return new LinkResource($link);
    }
}
