<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiaFestivo;

class DiaFestivoController extends Controller
{

    public function data()
    {
        $diasFestivos = DiaFestivo::all();
        return response()->json($diasFestivos);
    }
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
        return redirect()->route('home')->with('success', 'Día festivo creado correctamente.');
    }


    public function deleteDia(Request $request, $id)
    {
        DiaFestivo::where('id', $id)->delete();

        return redirect()->route('home');
    }


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
