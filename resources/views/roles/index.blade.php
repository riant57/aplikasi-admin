<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manajemen Role</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100">

    <div class="flex min-h-screen">

        @include('layouts.sidebar')

        <main class="flex-1 p-8">

            <div class="mx-auto max-w-6xl p-8">

                <div class="mb-6">
                    <a href="{{ route('home') }}"
                    class="text-sm text-blue-600 hover:underline">
                        &larr; Kembali ke Dashboard
                    </a>

                    {{-- <h1 class="mt-4 text-3xl font-bold text-gray-800">
                        Manajemen Role
                    </h1>

                    <p class="mt-2 text-gray-600">
                        Kelola role dan permission dalam aplikasi.
                    </p> --}}

                    <div class="mt-4 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">
                                Manajemen Role
                            </h1>

                            <p class="mt-2 text-gray-600">
                                Kelola role dan permission dalam aplikasi.
                            </p>
                        </div>

                        @can('roles.create')
                            <button
                                type="button"
                                onclick="document.getElementById('formRole').classList.toggle('hidden')"
                                class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700"
                            >
                                + Tambah Role
                            </button>
                        @endcan
                    </div>
                </div>


                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-800">
                        <p class="font-semibold">Terjadi kesalahan:</p>

                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @can('roles.create')
                    <div id="formRole" class="mb-6 hidden rounded-xl bg-white p-6 shadow">

                        <h2 class="mb-4 text-lg font-semibold text-gray-800">
                            Tambah Role Baru
                        </h2>

                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf

                            <div>
                                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                                    Nama Role
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Contoh: Manager"
                                    required
                                    maxlength="255"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none"
                                >
                            </div>

                            <div class="mt-4 flex gap-3">
                                <button
                                    type="submit"
                                    class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700"
                                >
                                    Simpan
                                </button>

                                <button
                                    type="button"
                                    onclick="document.getElementById('formRole').classList.add('hidden')"
                                    class="rounded-lg border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50"
                                >
                                    Batal
                                </button>
                            </div>
                        </form>

                    </div>
                @endcan



                <div class="overflow-hidden rounded-xl bg-white shadow">

                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="font-semibold text-gray-800">
                            Daftar Role
                        </h2>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full text-left text-sm">

                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="px-6 py-4">No.</th>
                                    <th class="px-6 py-4">Nama Role</th>
                                    <th class="px-6 py-4">Jumlah Permission</th>
                                    <th class="px-6 py-4">Guard</th>
                                    <th class="px-6 py-4">Atur Permission</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @forelse ($roles as $role)

                                    <tr class="hover:bg-gray-50">

                                        <td class="px-6 py-4">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-6 py-4 font-medium text-gray-800">
                                            {{ $role->name }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $role->permissions->count() }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $role->guard_name }}
                                        </td>
                                        <td>
                                            @can('roles.edit')
                                                <a
                                                    href="{{ route('roles.permissions.edit', $role) }}"
                                                    class="text-blue-600 hover:underline"
                                                >
                                                    Atur Permission
                                                </a>
                                            @endcan
                                        </td>
                                        
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-8 text-center text-gray-500">
                                            Belum ada role.
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