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


    /**
     * La función `createUser` valida y crea un nuevo usuario con la contraseña predeterminada
     * '12345678' en una aplicación PHP.
     * 
     * @param Request request El parámetro `request` en la función `createUser` es una instancia de la
     * clase `Illuminate\Http\Request` en Laravel. Representa la solicitud HTTP que se realiza al
     * servidor y contiene datos como entradas de formulario, encabezados y otra información de la
     * solicitud.
     * 
     * @return La función `createUser` devuelve una respuesta de redireccionamiento a la ruta
     * denominada 'usuarios'.
     */
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

    /**
     * La función eliminarUsuario elimina un usuario en función del ID proporcionado y lo redirige a la
     * ruta de 'usuarios'.
     * 
     * @param Request request El parámetro `request` en la función `deleteUser` es una instancia de la
     * clase `Illuminate\Http\Request` en Laravel. Representa la solicitud HTTP que se realiza al
     * servidor y le permite acceder a datos de entrada, encabezados, cookies y más.
     * 
     * @return La función `deleteUser` elimina un usuario con el ID especificado de la base de datos y
     * luego lo redirige a la ruta de los 'usuarios'.
     */
    public function deleteUser(Request $request)
    {
        User::where('id', $request->id)->delete();

        return redirect()->route('usuarios');
    }


    /**
     * La función updateUser actualiza la información del usuario en una aplicación PHP.
     * 
     * @param Request request  es un objeto que representa la solicitud HTTP realizada al
     * servidor. Contiene información como datos de formulario, encabezados y archivos enviados en la
     * solicitud. En este contexto, el parámetro  se utiliza para recuperar y validar los datos
     * enviados en la solicitud para actualizar la información de un usuario.
     * @param id El parámetro `id` en la función `updateUser` representa el identificador único del
     * usuario que desea actualizar. Se utiliza para encontrar el registro de usuario específico en la
     * base de datos que necesita actualizarse.
     * 
     * @return La función `updateUser` devuelve una respuesta de redireccionamiento a la ruta
     * denominada 'usuarios'.
     */
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
