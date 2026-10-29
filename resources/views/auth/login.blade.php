@extends('layouts.auth')

@section('title', 'Login - Aplikasi Admin')

@section('content')
<div class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl shadow-slate-200/60">

        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-600 text-2xl font-bold text-white">
                A
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Aplikasi Admin
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Silakan masuk ke akun Anda
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-slate-700">
                    Email
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    required
                    autofocus
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                    placeholder="nama@contoh.com"
                >
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                    Password
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                    placeholder="Masukkan password"
                >
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input
                    type="checkbox"
                    name="remember"
                    value="1"
                    class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                >
                Ingat saya
            </label>

            <button
                type="submit"
                class="w-full rounded-lg bg-indigo-600 px-4 py-3 font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200"
            >
                Masuk
            </button>
        </form>

        <p class="mt-8 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} Aplikasi Admin
        </p>
    </div>
</div>
@endsection