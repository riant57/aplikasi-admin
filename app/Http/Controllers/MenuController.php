<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('children')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        return view('menus.index', compact('menus'));
    }


    public function create()
    {
        $parents = Menu::whereNull('parent_id')
            ->whereNull('route')
            ->orderBy('order')
            ->get();

        $permissions = \Spatie\Permission\Models\Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('menus.create', compact('parents', 'permissions'));
    }

    public function store(Request $request)
    {
        $availableRoutes = collect(Route::getRoutes())
            ->map(fn ($route) => $route->getName())
            ->filter()
            ->all();
        $validated = $request->validate([
            'parent_id' => ['nullable', 'exists:menus,id'],
            'name' => ['required', 'string', 'max:255'],
            'route' => [
                            'nullable',
                            'string',
                            'max:255',
                            Rule::in($availableRoutes),
                        ],
            'permission_name' => [
                                    'nullable',
                                    Rule::exists('permissions', 'name')
                                        ->where('guard_name', 'web'),
                                ],
            'icon' => ['nullable', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        if (!empty($validated['parent_id'])) {
            $parent = Menu::findOrFail($validated['parent_id']);

            if ($parent->parent_id !== null || $parent->route !== null) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'parent_id' => 'Menu induk harus berupa menu utama tanpa route.',
                    ]);
            }
        }

        if (!empty($validated['parent_id']) && empty($validated['route'])) {
            return back()
                ->withInput()
                ->withErrors([
                    'route' => 'Submenu wajib memiliki route.',
                ]);
        }

        Menu::create($validated);

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil dibuat.');
    }

    public function edit(Menu $menu)
    {
        $parents = Menu::whereNull('parent_id')
            ->whereNull('route')
            ->where('id', '!=', $menu->id)
            ->orderBy('order')
            ->get();

        $permissions = \Spatie\Permission\Models\Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('menus.edit', compact(
            'menu',
            'parents',
            'permissions'
        ));
    }

    public function update(Request $request, Menu $menu)
    {
        $availableRoutes = collect(Route::getRoutes())
            ->map(fn ($route) => $route->getName())
            ->filter()
            ->all();
        $validated = $request->validate([
            'parent_id' => ['nullable', 'exists:menus,id'],
            'name' => ['required', 'string', 'max:255'],
            'route' => [
                            'nullable',
                            'string',
                            'max:255',
                            Rule::in($availableRoutes),
                        ],
            'permission_name' => [
                                    'nullable',
                                    Rule::exists('permissions', 'name')
                                        ->where('guard_name', 'web'),
                                ],
            'icon' => ['nullable', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($validated['parent_id'] == $menu->id) {
            return back()
                ->withInput()
                ->withErrors([
                    'parent_id' => 'Menu tidak bisa menjadi induk bagi dirinya sendiri.',
                ]);
        }

        if (!empty($validated['parent_id'])) {
            $parent = Menu::findOrFail($validated['parent_id']);

            if ($parent->parent_id !== null || $parent->route !== null) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'parent_id' => 'Menu induk harus berupa menu utama tanpa route.',
                    ]);
            }

            if (empty($validated['route'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'route' => 'Submenu wajib memiliki route.',
                    ]);
            }
        }

        // Jika menu memiliki submenu, menu tersebut tidak boleh
        // dipindahkan menjadi submenu.
        if ($menu->children()->exists() && !empty($validated['parent_id'])) {
            return back()
                ->withInput()
                ->withErrors([
                    'parent_id' => 'Menu yang memiliki submenu tidak bisa dijadikan submenu.',
                ]);
        }

        // Menu yang memiliki submenu harus tetap tanpa route.
        if ($menu->children()->exists() && !empty($validated['route'])) {
            return back()
                ->withInput()
                ->withErrors([
                    'route' => 'Menu induk yang memiliki submenu tidak boleh memiliki route.',
                ]);
        }

        $menu->update($validated);

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        // Cek apakah menu masih memiliki submenu
        if ($menu->children()->exists()) {
            return redirect()
                ->route('menus.index')
                ->with('error', 'Menu tidak bisa dihapus karena masih memiliki submenu.');
        }

        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }

}