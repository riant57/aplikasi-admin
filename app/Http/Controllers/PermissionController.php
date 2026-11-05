<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('permissions.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*$/',
                Rule::unique('permissions', 'name')
                    ->where('guard_name', 'web'),
            ],
        ]);

        Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission berhasil dibuat.');
    }

    public function destroy(Permission $permission)
    {
        // Cek apakah permission masih digunakan oleh menu
        $isUsedByMenu = Menu::where(
            'permission_name',
            $permission->name
        )->exists();

        if ($isUsedByMenu) {
            return redirect()
                ->route('permissions.index')
                ->with(
                    'error',
                    'Permission tidak bisa dihapus karena masih digunakan oleh menu.'
                );
        }

        $permission->delete();

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission berhasil dihapus.');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*$/',
                Rule::unique('permissions', 'name')
                    ->where('guard_name', 'web')
                    ->ignore($permission->id),
            ],
        ]);

        DB::transaction(function () use ($validated, $permission) {

            $oldName = $permission->name;
            $newName = $validated['name'];

            // Update nama permission
            $permission->update([
                'name' => $newName,
            ]);

            // Update referensi permission pada tabel menus
            Menu::where('permission_name', $oldName)
                ->update([
                    'permission_name' => $newName,
                ]);

        });

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission berhasil diperbarui.');
    }

}