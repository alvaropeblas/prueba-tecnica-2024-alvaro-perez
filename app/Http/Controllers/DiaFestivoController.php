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
            'color' => 'required|string|max:7', // Validar que el color sea un valor hexadecimal válido
            'dia' => 'required|integer|min:1|max:31',
            'mes' => 'required|integer|min:1|max:12',
            'anyo' => 'required|integer|min:' . date('Y') . '|max:9999', // Año mínimo es el actual
            'recurrente' => 'boolean', // El campo recurrente debe ser booleano (opcional)
        ]);
        DiaFestivo::create([
            'nombre' => $request->nombre,
            'color' => $request->color,
            'dia' => $request->dia,
            'mes' => $request->mes,
            'anyo' => $request->anyo,
            'recurrente' => $request->has('recurrente'), // Convertir a booleano
        ]);
        return redirect()->route('home')->with('success', 'Día festivo creado correctamente.');
    }
}
