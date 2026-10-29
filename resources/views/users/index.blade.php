<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Users</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="flex min-h-screen">

        @include('layouts.sidebar')

        <main class="flex-1 p-8">

            <div class="max-w-6xl mx-auto">

                <div class="bg-white rounded-xl shadow p-6">

                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold">
                                Manajemen Users
                            </h1>

                            <p class="text-gray-600 mt-1">
                                Daftar pengguna aplikasi.
                            </p>
                            <br>
                            @can('users.create')
                                <a
                                    href="{{ route('users.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-medium"
                                >
                                    + Tambah Pengguna
                                </a>
                            @endcan
                        </div>

                        <form action="{{ route('users.index') }}" method="GET" class="mb-6">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ $search ?? '' }}"
                                    placeholder="Cari nama atau email pengguna..."
                                    class="w-full sm:flex-1 rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                                >

                                <button
                                    type="submit"
                                    class="rounded-lg bg-blue-600 px-5 py-3 font-medium text-white hover:bg-blue-700"
                                >
                                    Cari
                                </button>

                                @if (!empty($search))
                                    <a
                                        href="{{ route('users.index') }}"
                                        class="rounded-lg bg-gray-200 px-5 py-3 text-center font-medium text-gray-700 hover:bg-gray-300"
                                    >
                                        Reset
                                    </a>
                                @endif
                            </div>

                        </form>

                        <span class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg text-sm font-semibold">
                            Total: {{ $users->total() }} pengguna
                        </span>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full border-collapse">

                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="border px-4 py-3">No.</th>
                                    <th class="border px-4 py-3">Nama</th>
                                    <th class="border px-4 py-3">Email</th>
                                    <th class="border px-4 py-3">Role</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($users as $user)
                                    <tr class="hover:bg-gray-50">

                                        <td class="border px-4 py-3">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="border px-4 py-3 font-medium">
                                            {{ $user->name }}
                                        </td>

                                        <td class="border px-4 py-3">
                                            {{ $user->email }}
                                        </td>

                                        <td class="border px-4 py-3">
                                            @forelse ($user->roles as $role)
                                                <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-sm mr-1 mb-1">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                <span class="text-gray-400 text-sm">
                                                    Belum ada role
                                                </span>
                                            @endforelse
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">

                                                {{-- Tombol Edit --}}
                                                @can('users.edit')
                                                    <a
                                                        href="{{ route('users.edit', $user->id) }}"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium"
                                                    >
                                                        Edit
                                                    </a>
                                                @endcan

                                                {{-- Tombol Hapus --}}
                                                @can('users.delete')
                                                    @if ($user->id !== auth()->id())
                                                        <form
                                                            action="{{ route('users.destroy', $user->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->name }}?')"
                                                        >
                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm font-medium"
                                                            >
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endcan

                                            </div>

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="border px-4 py-6 text-center text-gray-500">
                                            Belum ada pengguna.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>
                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>

                    </div>

                    <div class="mt-6">
                        <a href="{{ route('home') }}"
                           class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                            Kembali ke Dashboard
                        </a>
                    </div>

                </div>

            </div>

        </main>

    </div>

</body>
</html>