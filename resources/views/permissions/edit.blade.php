<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Permission</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8">
            <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">

                <h1 class="text-2xl font-bold mb-6">Edit Permission</h1>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('permissions.update', $permission) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label class="block font-medium mb-1">
                            Nama Permission
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $permission->name) }}"
                            class="w-full border rounded px-3 py-2"
                            required
                        >
                    </div>

                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        >
                            Simpan Perubahan
                        </button>

                        <a
                            href="{{ route('permissions.index') }}"
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