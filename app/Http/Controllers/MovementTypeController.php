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
    }

    public function show($id)
    {
        $movementType = MovementType::findOrFail($id);
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
    }

    public function edit($id)
    {
        $movementType = MovementType::findOrFail($id);
        return view('movement_types.edit', compact('movementType'));
    }

    public function update(Request $request, $id)
    {
        $type = MovementType::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'effect' => 'sometimes|required|in:in,out',
        ]);
        $type->update($data);
        return redirect()->route('movement-types.index')->with('success', 'Tipo de movimiento actualizado exitosamente');
    }

    public function destroy($id)
    {
        $type = MovementType::findOrFail($id);
        $type->delete();
        return redirect()->route('movement-types.index')->with('success', 'Tipo de movimiento eliminado exitosamente');
    }
}
