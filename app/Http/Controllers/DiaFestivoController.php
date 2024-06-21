<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiaFestivo;

class DiaFestivoController extends Controller
{

    /**
     * La función "datos" recupera todas las fechas festivas y las devuelve como una respuesta JSON.
     * 
     * @return La función `data()` devuelve una respuesta JSON que contiene todos los registros del
     * modelo `DiaFestivo`.
     */
    public function data()
    {
        $diasFestivos = DiaFestivo::all();
        return response()->json($diasFestivos);
    }

    /**
     * La función `createDia` valida y crea un nuevo registro DiaFestivo
     * 
     * @param Request request La función `createDia` e crea un nuevo registro en
     * una tabla de base de datos para un DiaFestivo (festivo) en función de los datos proporcionados
     * en la solicitud. La función primero valida los datos de la solicitud entrante para garantizar
     * que cumplan con los criterios especificados. 
     * 
     * @return La función `createDia` devuelve una respuesta de redireccionamiento a la ruta 'inicio'
     * después de crear un nuevo registro en el modelo `DiaFestivo` basado en los datos de la solicitud
     * validada.
     */
    public function createDia(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'dia' => 'required|integer|min:1|max:31',
            'mes' => 'required|integer|min:1|max:12',
            'recurrente' => 'boolean',
        ]);
        DiaFestivo::create([
            'nombre' => $request->nombre,
            'color' => $request->color,
            'dia' => $request->dia,
            'mes' => $request->mes,
            'anyo' => $request->has('recurrente') ? null : $request->anyo,
            'recurrente' => $request->has('recurrente'),
        ]);
        return redirect()->route('home');
    }


    /**
     * La función `deleteDia` elimina un registro del modelo `DiaFestivo` basándose en el ``
     * proporcionado y luego redirige a la ruta 'inicio'.
     * 
     * @param Request request El parámetro `request` en la función `deleteDia` es una instancia de la
     * clase `Illuminate\Http\Request`. Representa la solicitud HTTP que se realiza al servidor. Este
     * parámetro le permite acceder a los datos enviados a través de la solicitud, como entradas de
     * formulario o parámetros de consulta.
     * @param id El parámetro `id` en la función `deleteDia` representa el identificador único del
     * registro DiaFestivo que desea eliminar de la base de datos. Se utiliza para localizar el
     * registro específico que debe eliminarse.
     * 
     * @return La función `deleteDia` elimina un registro del modelo `DiaFestivo` según el `id`
     * proporcionado. Después de eliminar el registro, la función redirige al usuario a la ruta 'home'.
     */
    public function deleteDia(Request $request, $id)
    {
        DiaFestivo::where('id', $id)->delete();

        return redirect()->route('home');
    }


    /**
     * La función `updateDia` en PHP actualiza una instancia del modelo DiaFestivo con datos validados
     * de una solicitud y redirige a la ruta de inicio.
     * 
     * @param Request request El parámetro `request` en la función `updateDia` es una instancia de la
     * clase `Illuminate\Http\Request`. Representa la solicitud HTTP que se realiza al servidor y
     * contiene datos como entradas de formulario, encabezados, cookies y archivos enviados junto con
     * la solicitud.
     * @param id El parámetro `id` en la función `updateDia` representa el identificador único del
     * DiaFestivo que desea actualizar. Este ID se utiliza para recuperar el registro DiaFestivo
     * específico de la base de datos utilizando el método `findOrFail` de Eloquent. Ayuda a asegurar
     * 
     * @return La función `updateDia` devuelve una respuesta de redireccionamiento a la ruta 'home'
     * después de actualizar el modelo DiaFestivo con los datos validados de la solicitud.
     */
    public function updateDia(Request $request, $id)
    {

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'dia' => 'required|integer|min:1|max:31',
            'mes' => 'required|integer|min:1|max:12',
            'recurrente' => 'boolean',
        ]);

        $diaFestivo = DiaFestivo::findOrFail($id);
        $diaFestivo->fill($validatedData);
        $diaFestivo->save();
        return redirect()->route('home');
    }
}
