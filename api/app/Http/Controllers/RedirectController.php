<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkStoreRequest;
use App\Http\Requests\RedirectUpdateRequest;
use App\Http\Resources\LinkResource;
use App\Http\Resources\RedirectResource;
use App\Redirect;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class RedirectController extends Controller
{
    public function listagem(Request $request)
    {
        $listRedirect = Redirect::all();
        return response()->json($listRedirect);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome_link' => 'string|required',
            'total_max_click' => 'required',
            'link_hash' => 'required',
            'link_default' => 'string|required'
        ]);

        $redirect = Redirect::create($data);


        return response()->json([
            $redirect
        ], 201);
        
    }

    public function show(Redirect $redirect)
    {
        $redirect->load('links');
        return new RedirectResource($redirect);
    }

    public function update(Redirect $redirect, RedirectUpdateRequest $request){
        $input = $request->validated();

        $redirect->fill($input);
        $redirect->save();

        return new RedirectResource($redirect->fresh());
    }

    public function addLink(Redirect $redirect, LinkStoreRequest $request)
    {
        $input = $request->validated();
        $link = $redirect->links()->create($input);

        return new LinkResource($link);
    }
}
