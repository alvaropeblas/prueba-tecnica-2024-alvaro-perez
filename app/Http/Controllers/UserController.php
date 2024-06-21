<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function data()
    {
        $users = User::all();
        return response()->json($users);
    }


    public function index()
    {
        return view('usuarios');
    }


    public function createUser(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => '12345678',
        ]);


        return redirect()->route('usuarios');
    }

    public function deleteUser(Request $request)
    {
        User::where('id', $request->id)->delete();

        return redirect()->route('usuarios');
    }


    public function updateUser(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,

        ]);

        $user = User::findOrFail($id);
        $user->fill($validatedData);
        $user->save();
        return redirect()->route('usuarios');
    }

}
