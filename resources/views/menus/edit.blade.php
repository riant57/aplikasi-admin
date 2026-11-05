<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">

        @include('layouts.sidebar')

        <main class="flex-1 p-8">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">

                <h1 class="text-2xl font-bold mb-6">Edit Menu</h1>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('menus.update', $menu) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Nama Menu</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $menu->name) }}"
                            class="w-full border rounded px-3 py-2"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Menu Induk</label>
                        <select name="parent_id" class="w-full border rounded px-3 py-2">
                            <option value="">-- Menu Utama --</option>

                            @foreach ($parents as $parent)
                                <option
                                    value="{{ $parent->id }}"
                                    @selected(old('parent_id', $menu->parent_id) == $parent->id)
                                >
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Route</label>
                        <input
                            type="text"
                            name="route"
                            value="{{ old('route', $menu->route) }}"
                            placeholder="Contoh: users.index"
                            class="w-full border rounded px-3 py-2"
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Permission</label>
                        <select name="permission_name" class="w-full border rounded px-3 py-2">
                            <option value="">-- Tanpa Permission --</option>

                            @foreach ($permissions as $permission)
                                <option
                                    value="{{ $permission->name }}"
                                    @selected(old('permission_name', $menu->permission_name) == $permission->name)
                                >
                                    {{ $permission->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Icon</label>
                        <input
                            type="text"
                            name="icon"
                            value="{{ old('icon', $menu->icon) }}"
                            placeholder="Contoh: users"
                            class="w-full border rounded px-3 py-2"
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Urutan</label>
                        <input
                            type="number"
                            name="order"
                            value="{{ old('order', $menu->order) }}"
                            min="0"
                            class="w-full border rounded px-3 py-2"
                            required
                        >
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium mb-1">Status</label>
                        <select name="is_active" class="w-full border rounded px-3 py-2">
                            <option value="1" @selected(old('is_active', $menu->is_active) == 1)>
                                Aktif
                            </option>
                            <option value="0" @selected(old('is_active', $menu->is_active) == 0)>
                                Nonaktif
                            </option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        >
                            Simpan Perubahan
                        </button>

                        <a
                            href="{{ route('menus.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                        >
                            Kembali
                        </a>
                    </div>

                </form>
            </div>
        </main>
    </div>
</body>
</html>