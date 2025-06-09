<?php

namespace App\Http\Controllers;

use App\Models\MovementType;
use Illuminate\Http\Request;

class MovementTypeController extends Controller
{
    public function index()
    {
        $movementTypes = MovementType::all();
        return view('movement_types.index', compact('movementTypes'));
    }

    public function create()
    {
        return view('movement_types.create');
    }    public function show(MovementType $movementType)
    {
        return view('movement_types.show', compact('movementType'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'effect' => 'required|in:in,out',
        ]);
        $type = MovementType::create($data);
        return redirect()->route('movement-types.index')->with('success', 'Tipo de movimiento creado exitosamente');
    }    public function edit(MovementType $movementType)
    {
        return view('movement_types.edit', compact('movementType'));
    }    public function update(Request $request, MovementType $movementType)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'effect' => 'sometimes|required|in:in,out',
        ]);
        $movementType->update($data);
        return redirect()->route('movement-types.index')->with('success', 'Tipo de movimiento actualizado exitosamente');
    }    public function destroy(MovementType $movementType)
    {
        $movementType->delete();
        return redirect()->route('movement-types.index')->with('success', 'Tipo de movimiento eliminado exitosamente');
    }
}
