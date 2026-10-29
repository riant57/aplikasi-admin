<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-xl shadow p-6">
                    <h1 class="text-2xl font-bold mb-2">Edit Pengguna</h1>
                    <p class="text-gray-600 mb-6">
                        Perbarui informasi akun pengguna.
                    </p>

                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-5">
                            <label for="name" class="block font-medium mb-2">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >

                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-5">
                            <label for="email" class="block font-medium mb-2">
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >

                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Role Pengguna
                            </label>

                            <div class="space-y-3 rounded-lg border border-gray-200 p-4">
                                @foreach ($roles as $role)
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input
                                            type="checkbox"
                                            name="roles[]"
                                            value="{{ $role->name }}"
                                            @checked(
                                                in_array(
                                                    $role->name,
                                                    old('roles', $user->roles->pluck('name')->all())
                                                )
                                            )
                                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        >

                                        <span class="text-sm text-gray-700">
                                            {{ $role->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            @error('roles')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            @error('roles.*')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <p class="mt-2 text-sm text-gray-500">
                                Pilih minimal satu role. Kamu dapat memilih lebih dari satu.
                            </p>
                        </div>

                        {{-- Permission Tambahan --}}

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Permission Tambahan
                            </label>

                        <p class="text-sm text-gray-500 mb-3">
                            Pilih hak akses tambahan yang diberikan langsung kepada pengguna ini,
                            di luar hak akses yang diperoleh dari role.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 rounded-lg border border-gray-200 p-4">
                            @forelse ($permissions as $permission)
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->name }}"
                                        @checked(
                                            in_array(
                                                $permission->name,
                                                old('permissions', $userPermissions)
                                            )
                                        )
                                        class="mt-1 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    >

                                    <span class="text-sm text-gray-700">
                                        {{ $permission->name }}
                                    </span>
                                </label>
                            @empty
                                <p class="text-sm text-gray-500">
                                    Belum ada permission yang tersedia.
                                </p>
                            @endforelse
                        </div>

                        @error('permissions')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @error('permissions.*')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        </div>

                        {{-- Password --}}
                        <div class="mb-5">
                            <label for="password" class="block font-medium mb-2">
                                Password Baru (Opsional)
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                autocomplete="new-password"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >

                            <p class="text-gray-500 text-sm mt-1">
                                Kosongkan jika tidak ingin mengganti password.
                            </p>

                            @error('password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-6">
                            <label for="password_confirmation" class="block font-medium mb-2">
                                Konfirmasi Password Baru
                            </label>

                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                autocomplete="new-password"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>

                        {{-- Tombol --}}
                        <div class="flex flex-wrap gap-3">
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-medium"
                            >
                                Simpan Perubahan
                            </button>

                            <a
                                href="{{ route('users.index') }}"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-3 rounded-lg font-medium"
                            >
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>