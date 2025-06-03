<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('parent', 'children', 'permissions', 'users')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $parentRoles = Role::all();
        $permissions = Permission::all();
        return view('roles.create', compact('parentRoles', 'permissions'));
    }

    public function show($id)
    {
        $role = Role::with('parent', 'children', 'permissions', 'users')->findOrFail($id);
        return view('roles.show', compact('role'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles',
            'description' => 'nullable|string',
            'is_system' => 'boolean',
            'parent_role_id' => 'nullable|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        $role = Role::create($data);
        
        if (isset($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }
        
        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $parentRoles = Role::where('id', '!=', $id)->get();
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'parentRoles', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|required|string|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'is_system' => 'boolean',
            'parent_role_id' => 'nullable|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        $role->update($data);
        
        if (isset($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }
          return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente');
    }
}
