<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        @include('layouts.sidebar')

        <main class="flex-1 p-8">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Tambah Menu
                </h1>

                <p class="text-gray-500 mt-1">
                    Tambahkan menu utama atau submenu.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 max-w-3xl">

                <form method="POST" action="{{ route('menus.store') }}">
                    @csrf

                    {{-- Nama Menu --}}
                    <div class="mb-5">
                        <label class="block font-medium mb-2">
                            Nama Menu
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border rounded-lg px-4 py-2"
                               required>

                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Menu Induk --}}
                    <div class="mb-5">
                        <label class="block font-medium mb-2">
                            Menu Induk
                        </label>

                        <select name="parent_id"
                                class="w-full border rounded-lg px-4 py-2">

                            <option value="">Menu Utama (Tidak memiliki induk)</option>

                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}"
                                    @selected(old('parent_id') == $parent->id)>
                                    {{ $parent->name }}
                                </option>
                            @endforeach

                        </select>

                        <p class="text-gray-500 text-sm mt-1">
                            Kosongkan jika ingin membuat menu utama.
                        </p>

                        @error('parent_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Route --}}
                    <div class="mb-5">
                        <label class="block font-medium mb-2">
                            Route
                        </label>

                        <input type="text"
                               name="route"
                               value="{{ old('route') }}"
                               placeholder="Contoh: users.index"
                               class="w-full border rounded-lg px-4 py-2">

                        @error('route')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Permission --}}
                    <div class="mb-5">
                        <label class="block font-medium mb-2">
                            Permission
                        </label>

                        <select name="permission_name"
                                class="w-full border rounded-lg px-4 py-2">

                            <option value="">Tanpa Permission</option>

                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->name }}"
                                    @selected(old('permission_name') == $permission->name)>
                                    {{ $permission->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('permission_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Icon --}}
                    <div class="mb-5">
                        <label class="block font-medium mb-2">
                            Icon
                        </label>

                        <input type="text"
                               name="icon"
                               value="{{ old('icon') }}"
                               placeholder="Contoh: users"
                               class="w-full border rounded-lg px-4 py-2">
                    </div>

                    {{-- Order --}}
                    <div class="mb-5">
                        <label class="block font-medium mb-2">
                            Urutan
                        </label>

                        <input type="number"
                               name="order"
                               value="{{ old('order', 0) }}"
                               min="0"
                               class="w-full border rounded-lg px-4 py-2"
                               required>

                        @error('order')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-6">
                        <label class="block font-medium mb-2">
                            Status
                        </label>

                        <select name="is_active"
                                class="w-full border rounded-lg px-4 py-2">

                            <option value="1" @selected(old('is_active', '1') == '1')>
                                Aktif
                            </option>

                            <option value="0" @selected(old('is_active') == '0')>
                                Nonaktif
                            </option>

                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3">

                        <button type="submit"
                                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Simpan
                        </button>

                        <a href="{{ route('menus.index') }}"
                           class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            Kembali
                        </a>

                    </div>

                </form>

            </div>

        </main>

    </div>

</body>
</html>