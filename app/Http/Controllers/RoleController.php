<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')
            ->orderBy('name')
            ->get();

        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9 _-]+$/',
                Rule::unique('roles', 'name')
                    ->where('guard_name', 'web'),
            ],
        ]);

        Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil dibuat.');
    }

    public function editPermissions(Role $role)
    {
        $permissions = Permission::where('guard_name', $role->guard_name)
            ->orderBy('name')
            ->get();

        $rolePermissions = $role->permissions()
            ->pluck('id')
            ->toArray();

        return view('roles.permissions', compact(
            'role',
            'permissions',
            'rolePermissions'
        ));
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [
                'integer',
                Rule::exists('permissions', 'id')
                    ->where('guard_name', $role->guard_name),
            ],
        ]);

        $permissionIds = $validated['permissions'] ?? [];

        $permissions = Permission::whereIn('id', $permissionIds)
            ->where('guard_name', $role->guard_name)
            ->get();

        $role->syncPermissions($permissions);

        return redirect()
            ->route('roles.permissions.edit', $role)
            ->with('success', 'Permission berhasil diperbarui.');
    }

}