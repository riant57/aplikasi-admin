<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menu Management</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        @include('layouts.sidebar')

        <main class="flex-1 p-8">

            <div class="flex items-center justify-between mb-6">

                <h1 class="text-2xl font-bold text-gray-800">
                    Menu Management
                </h1>
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                @can('menus.create')
                    <a href="{{ route('menus.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            + Tambah Menu
                    </a>
                @endcan

            </div>

            <div class="bg-white rounded-xl shadow overflow-hidden">

                <table class="w-full text-left">

                    <thead class="bg-gray-50 border-b">

                        <tr>
                            <th class="px-6 py-4">Menu</th>
                            <th class="px-6 py-4">Route</th>
                            <th class="px-6 py-4">Permission</th>
                            <th class="px-6 py-4">Urutan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y">

                        @forelse ($menus as $menu)

                            {{-- Menu utama --}}
                            <tr>

                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $menu->name }}
                                </td>

                                <td class="px-6 py-4 text-gray-500">
                                    {{ $menu->route ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-gray-500">
                                    {{ $menu->permission_name ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $menu->order }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                                </td>
                                <td class="px-4 py-2">
                                    @can('menus.edit')
                                        <a
                                            href="{{ route('menus.edit', $menu) }}"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                                        >
                                            Edit
                                        </a>
                                    @endcan

                                    @can('menus.delete')
                                        <form
                                            action="{{ route('menus.destroy', $menu) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus menu ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    @endcan

                                </td>

                            </tr>

                            {{-- Submenu --}}
                            @foreach ($menu->children as $child)

                                <tr class="bg-gray-50">

                                    <td class="px-6 py-4 pl-12 text-gray-700">
                                        ↳ {{ $child->name }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $child->route ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $child->permission_name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $child->order }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $child->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        @can('menus.edit')
                                            <a
                                                href="{{ route('menus.edit', $child) }}"
                                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                                            >
                                                Edit
                                            </a>
                                        @endcan

                                        @can('menus.delete')
                                            <form
                                                action="{{ route('menus.destroy', $child) }}"
                                                method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus menu ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                                >
                                                    Hapus
                                                </button>
                                            </form>
                                        @endcan
                                    </td>

                                </tr>

                            @endforeach

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="px-6 py-8 text-center text-gray-500">

                                    Belum ada data menu.

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </main>

    </div>

</body>
</html>