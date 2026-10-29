@extends('layouts.auth')

@section('title', 'Dashboard - Aplikasi Admin')

@section('content')
<div class="min-h-screen bg-slate-100">

    {{-- Navbar --}}
    <nav class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

            <h1 class="text-xl font-bold text-indigo-600">
                Aplikasi Admin
            </h1>

            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-600">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg bg-red-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-600"
                    >
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </nav>

    <body class="bg-gray-100 min-h-screen">

        <div class="flex min-h-screen">

            @include('layouts.sidebar')

            <main class="flex-1 p-8">

                            {{-- Konten Dashboard --}}
                <main class="mx-auto max-w-7xl px-6 py-10">

                    <h2 class="text-2xl font-bold text-slate-900">
                        Dashboard
                    </h2>

                    <p class="mt-2 text-slate-500">
                        Selamat datang di aplikasi admin.
                    </p>

                    <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3">

                        <div class="rounded-xl bg-white p-6 shadow-sm">
                            <p class="text-sm text-slate-500">Pengguna</p>
                            <h3 class="mt-2 text-2xl font-bold text-slate-900">
                                {{ \App\Models\User::count() }}
                            </h3>
                        </div>

                        <div class="rounded-xl bg-white p-6 shadow-sm">
                            <p class="text-sm text-slate-500">Role</p>
                            <h3 class="mt-2 text-2xl font-bold text-slate-900">
                                0
                            </h3>
                            <p class="mt-1 text-xs text-slate-400">
                                Belum dikonfigurasi
                            </p>
                        </div>

                        <div class="rounded-xl bg-white p-6 shadow-sm">
                            <p class="text-sm text-slate-500">Permission</p>
                            <h3 class="mt-2 text-2xl font-bold text-slate-900">
                                0
                            </h3>
                            <p class="mt-1 text-xs text-slate-400">
                                Belum dikonfigurasi
                            </p>
                        </div>

                    </div>

                </main>

            </main>

        </div>

    </body>

    



    
</div>
@endsection