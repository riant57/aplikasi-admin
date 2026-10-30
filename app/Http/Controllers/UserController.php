<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('roles')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(3)
            ->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    public function create()
    {
        $roles = \Spatie\Permission\Models\Role::orderBy('name')->get();
        return view('users.create', compact('roles'));
    }

    // public function edit(User $user)
    // {
    //     $roles = \Spatie\Permission\Models\Role::orderBy('name')->get();

    //     $user->load('roles');

    //     return view('users.edit', compact('user', 'roles'));
    // }

    public function edit(User $user)
    {
        $roles = Role::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        $permissions = Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        $user->load('roles');

        $userPermissions = $user->getDirectPermissions()
            ->pluck('name')
            ->all();

        return view('users.edit', compact(
            'user',
            'roles',
            'permissions',
            'userPermissions'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            //'role' => ['required', 'string', 'exists:roles,name,guard_name,web',],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => [
                'required',
                'string',
                'distinct',
                'exists:roles,name,guard_name,web',
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        //$user->assignRole($validated['role']);
        $user->syncRoles($validated['roles']);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],
            //'role' => ['required','string', 'exists:roles,name,guard_name,web',],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => [
                'required',
                'string',
                'distinct',
                'exists:roles,name,guard_name,web',
            ],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [
                'required',
                'string',
                'distinct',
                'exists:permissions,name,guard_name,web',
            ],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        //$user->syncRoles([$validated['role']]);
        $user->syncRoles($validated['roles']);

        $user->syncPermissions($validated['permissions'] ?? []);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
    // Mencegah akun yang sedang login menghapus dirinya sendiri.
    if ($user->id === auth()->id()) {
    return redirect()
    ->route('users.index')
    ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
    }

    $user->delete();

    return redirect()
        ->route('users.index')
        ->with('success', 'Pengguna berhasil dihapus.');

    }
}