<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\Error;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use LDAP\Result;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            'name' => 'required|min:6',
            'email' => 'email',
            'password' => ['required' , Password::min(8)]
        ]);

        if ($validator->fails())
        {
            return response()->json(["errors" => $validator->errors()],422);
        }

        $user = User::create($request->all());

        return response($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $user)
    {
        $user = User::findOrFail($user);
        return response($user);
        // return response("failes", 404);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $product = User::find($id);

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        $validator = Validator::make($request->all() ,[
            'name' => 'required|min:6',
            'email' => 'email',
            'password' => ['required' , Password::min(8)]
        ]);

        if ($validator->fails())
        {
            return response()->json(["errors" => $validator->errors()],422);
        }

        $product->update($request->all());

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado con éxito'], 204);

    }
}
