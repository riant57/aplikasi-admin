<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Permission Management</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Konten utama --}}
        <main class="flex-1 p-8">

            <div class="max-w-6xl mx-auto">

                {{-- Header --}}
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">
                        Permission Management
                    </h1>

                    <p class="text-gray-600 mt-1">
                        Kelola hak akses yang tersedia dalam aplikasi.
                    </p>
                </div>

                {{-- Pesan sukses --}}
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Pesan validasi --}}
                @if ($errors->any())
                    <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form tambah permission --}}
                @can('permissions.manage')
                    <div class="bg-white rounded-xl shadow p-6 mb-6">

                        <h2 class="text-lg font-semibold mb-4">
                            Tambah Permission
                        </h2>

                        <form
                            action="{{ route('permissions.store') }}"
                            method="POST"
                        >
                            @csrf

                            <div class="flex flex-col md:flex-row gap-3">

                                <div class="flex-1">
                                    <label
                                        for="name"
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Nama Permission
                                    </label>

                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="Contoh: products.view"
                                        required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    >
                                </div>

                                <div class="flex items-end">
                                    <button
                                        type="submit"
                                        class="w-full md:w-auto bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700"
                                    >
                                        Simpan Permission
                                    </button>
                                </div>

                            </div>

                            <p class="text-sm text-gray-500 mt-2">
                                Gunakan format modul.aksi, misalnya
                                products.view atau products.create.
                            </p>

                        </form>

                    </div>
                @endcan

                {{-- Tabel permission --}}
                <div class="bg-white rounded-xl shadow overflow-hidden">

                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold">
                            Daftar Permission
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Total {{ $permissions->count() }} permission.
                        </p>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full text-left">

                            <thead class="bg-gray-50 text-gray-600 text-sm">
                                <tr>
                                    <th class="px-6 py-4">No.</th>
                                    <th class="px-6 py-4">Modul</th>
                                    <th class="px-6 py-4">Aksi</th>
                                    <th class="px-6 py-4">Nama Permission</th>
                                    <th class="px-6 py-4">Guard</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @forelse ($permissions as $index => $permission)

                                    @php
                                        $parts = explode('.', $permission->name);
                                    @endphp

                                    <tr class="hover:bg-gray-50">

                                        <td class="px-6 py-4">
                                            {{ $index + 1 }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                                {{ $parts[0] }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $parts[1] ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4 font-medium text-gray-800">
                                            {{ $permission->name }}
                                        </td>

                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $permission->guard_name }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada permission.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </main>

    </div>

</body>
</html>