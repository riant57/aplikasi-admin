<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengaturan Permission</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="max-w-5xl mx-auto p-6">

        <div class="bg-white rounded-xl shadow p-6">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">
                        Pengaturan Permission
                    </h1>

                    <p class="text-gray-600 mt-1">
                        Role: <strong>{{ $role->name }}</strong>
                    </p>
                </div>

                <a href="{{ route('roles.index') }}"
                   class="text-blue-600 hover:underline">
                    Kembali
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('roles.permissions.update', $role) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                @php
                    $groups = $permissions->groupBy(function ($permission) {
                        return explode('.', $permission->name)[0];
                    });

                    $selectedPermissions = old(
                        'permissions',
                        $rolePermissions
                    );
                @endphp

                <div class="space-y-6">

                    @foreach ($groups as $groupName => $groupPermissions)

                        <div class="border rounded-lg p-4">

                            <h2 class="font-semibold text-lg mb-3 capitalize">
                                {{ $groupName }}
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                                @foreach ($groupPermissions as $permission)

                                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50">

                                        <input
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->id }}"
                                            class="rounded border-gray-300 text-blue-600"
                                            @checked(
                                                in_array(
                                                    $permission->id,
                                                    $selectedPermissions
                                                )
                                            )
                                        >

                                        <span class="text-gray-700">
                                            {{ $permission->name }}
                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        </div>

                    @endforeach

                </div>

                <div class="mt-6 flex justify-end gap-3">

                    <a href="{{ route('roles.index') }}"
                       class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Simpan Permission
                    </button>

                </div>

            </form>

        </div>

    </div>

</body>
</html>