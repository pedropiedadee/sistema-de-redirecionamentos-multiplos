<?php

namespace App\Http\Controllers;

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
            'link_hash' => 'required'
        ]);

        $redirect = Redirect::create($data);


        return response()->json([
            'message' => 'Redirect Criado'
        ], 201);
        
    }
}
