<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('roles')->get();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function show($id)
    {
        $permission = Permission::with('roles')->findOrFail($id);
        return view('permissions.show', compact('permission'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:permissions',
            'description' => 'nullable|string',
            'module' => 'nullable|string',
        ]);
        $permission = Permission::create($data);
        return redirect()->route('permissions.index')->with('success', 'Permiso creado exitosamente');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|required|string|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string',
            'module' => 'nullable|string',
        ]);
        $permission->update($data);
        return redirect()->route('permissions.index')->with('success', 'Permiso actualizado exitosamente');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permiso eliminado exitosamente');
    }
}
