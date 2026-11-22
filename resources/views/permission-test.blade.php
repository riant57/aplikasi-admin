<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Permission Test</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="max-w-3xl mx-auto p-6">

        <div class="bg-white rounded-xl shadow p-6">

            <h1 class="text-2xl font-bold mb-2">
                Permission Test
            </h1>

            <p class="text-gray-600 mb-6">
                User: <strong>{{ auth()->user()->name }}</strong>
            </p>

            @php
                $permissions = [
                    'audit.alpha',
                    'audit.beta',
                    'audit.gamma',
                ];
            @endphp

            <div class="space-y-3">

                @foreach ($permissions as $permission)

                    <div class="flex justify-between items-center border rounded-lg p-4">

                        <span class="font-medium">
                            {{ $permission }}
                        </span>

                        @can($permission)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                DIIZINKAN
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                DITOLAK
                            </span>
                        @endcan

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</body>
</html>