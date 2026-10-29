@extends('layouts.auth')

@section('title', 'Edit Cabang - Aplikasi Admin')

@section('content')
<div class="flex min-h-screen bg-slate-100">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Konten utama --}}
    <div class="flex-1 min-w-0">

        {{-- Navbar --}}
        <nav class="flex items-center justify-between bg-white px-6 py-4 shadow-sm">
            <h1 class="text-xl font-semibold text-slate-800">
                Edit Cabang
            </h1>

            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-600">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                    >
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        {{-- Isi halaman --}}
        <main class="p-6">

            <div class="mb-6">
                <a
                    href="{{ route('branches.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-800"
                >
                    &larr; Kembali ke Daftar Cabang
                </a>

                <p class="mt-2 text-sm text-slate-500">
                    Perbarui informasi cabang di bawah ini.
                </p>
            </div>

            <div class="mx-auto max-w-3xl rounded-xl bg-white p-6 shadow-sm">

                <h2 class="mb-6 text-lg font-semibold text-slate-800">
                    Form Edit Cabang
                </h2>

                {{-- Error validasi --}}
                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <p class="mb-2 font-semibold">
                            Terdapat kesalahan:
                        </p>

                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ route('branches.update', $branch->id) }}"
                    method="POST"
                    class="space-y-5"
                >
                    @csrf
                    @method('PUT')

                    {{-- Kode Cabang --}}
                    <div>
                        <label
                            for="code"
                            class="mb-1 block text-sm font-medium text-slate-700"
                        >
                            Kode Cabang <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="code"
                            name="code"
                            value="{{ old('code', $branch->code) }}"
                            maxlength="20"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >

                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Cabang --}}
                    <div>
                        <label
                            for="name"
                            class="mb-1 block text-sm font-medium text-slate-700"
                        >
                            Nama Cabang <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $branch->name) }}"
                            maxlength="100"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label
                            for="address"
                            class="mb-1 block text-sm font-medium text-slate-700"
                        >
                            Alamat
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >{{ old('address', $branch->address) }}</textarea>

                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kota --}}
                    <div>
                        <label
                            for="city"
                            class="mb-1 block text-sm font-medium text-slate-700"
                        >
                            Kota <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="city"
                            name="city"
                            value="{{ old('city', $branch->city) }}"
                            maxlength="100"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >

                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Telepon --}}
                    <div>
                        <label
                            for="phone"
                            class="mb-1 block text-sm font-medium text-slate-700"
                        >
                            Telepon
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone', $branch->phone) }}"
                            maxlength="20"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >

                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label
                            for="is_active"
                            class="mb-1 block text-sm font-medium text-slate-700"
                        >
                            Status Cabang <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="is_active"
                            name="is_active"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >
                            <option
                                value="1"
                                @selected((string) old('is_active', (int) $branch->is_active) === '1')
                            >
                                Aktif
                            </option>

                            <option
                                value="0"
                                @selected((string) old('is_active', (int) $branch->is_active) === '0')
                            >
                                Tidak Aktif
                            </option>
                        </select>

                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-3 border-t border-slate-100 pt-5">
                        <a
                            href="{{ route('branches.index') }}"
                            class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700"
                        >
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>
</div>
@endsection
