@extends('layouts.auth')

@section('title', 'Manajemen Cabang - Aplikasi Admin')

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

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Konten utama --}}
        <main class="flex-1 p-8">

            <div class="mx-auto max-w-7xl">

                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">
                            Manajemen Cabang
                        </h2>

                        <p class="mt-2 text-slate-500">
                            Kelola data cabang perusahaan.
                        </p>
                    </div>

                    @can('branches.create')
                        <a
                            href="#form-tambah-cabang"
                            class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                        >
                            + Tambah Cabang
                        </a>
                    @endcan
                </div>

                {{-- Pesan sukses --}}
                @if (session('success'))
                    <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Form tambah cabang --}}
                @can('branches.create')
                    <div
                        id="form-tambah-cabang"
                        class="mb-8 rounded-xl bg-white p-6 shadow-sm"
                    >
                        <h3 class="mb-6 text-lg font-semibold text-slate-800">
                            Tambah Cabang
                        </h3>

                        @if ($errors->any())
                            <div class="mb-6 rounded-lg bg-red-100 p-4 text-red-700">
                                <p class="mb-2 font-medium">
                                    Terdapat kesalahan pada input:
                                </p>

                                <ul class="list-inside list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form
                            action="{{ route('branches.store') }}"
                            method="POST"
                        >
                            @csrf

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                                {{-- Kode cabang --}}
                                <div>
                                    <label
                                        for="code"
                                        class="mb-2 block text-sm font-medium text-slate-700"
                                    >
                                        Kode Cabang <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="code"
                                        name="code"
                                        value="{{ old('code') }}"
                                        maxlength="20"
                                        required
                                        placeholder="Contoh: CBG001"
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                    >
                                </div>

                                {{-- Nama cabang --}}
                                <div>
                                    <label
                                        for="name"
                                        class="mb-2 block text-sm font-medium text-slate-700"
                                    >
                                        Nama Cabang <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        maxlength="100"
                                        required
                                        placeholder="Contoh: Cabang Surabaya"
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                    >
                                </div>

                                {{-- Kota --}}
                                <div>
                                    <label
                                        for="city"
                                        class="mb-2 block text-sm font-medium text-slate-700"
                                    >
                                        Kota <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="city"
                                        name="city"
                                        value="{{ old('city') }}"
                                        maxlength="100"
                                        required
                                        placeholder="Contoh: Surabaya"
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                    >
                                </div>

                                {{-- Telepon --}}
                                <div>
                                    <label
                                        for="phone"
                                        class="mb-2 block text-sm font-medium text-slate-700"
                                    >
                                        Nomor Telepon
                                    </label>

                                    <input
                                        type="text"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        maxlength="20"
                                        placeholder="Contoh: 0311234567"
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                    >
                                </div>

                                {{-- Alamat --}}
                                <div class="md:col-span-2">
                                    <label
                                        for="address"
                                        class="mb-2 block text-sm font-medium text-slate-700"
                                    >
                                        Alamat
                                    </label>

                                    <textarea
                                        id="address"
                                        name="address"
                                        rows="3"
                                        placeholder="Masukkan alamat lengkap cabang"
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                    >{{ old('address') }}</textarea>
                                </div>

                                {{-- Status --}}
                                <div>
                                    <label
                                        for="is_active"
                                        class="mb-2 block text-sm font-medium text-slate-700"
                                    >
                                        Status <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="is_active"
                                        name="is_active"
                                        required
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                    >
                                        <option value="1" @selected(old('is_active', '1') == '1')>
                                            Aktif
                                        </option>

                                        <option value="0" @selected(old('is_active') === '0')>
                                            Nonaktif
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <div class="mt-6 flex gap-3">
                                <button
                                    type="submit"
                                    class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                                >
                                    Simpan Cabang
                                </button>

                                <a
                                    href="{{ route('branches.index') }}"
                                    class="rounded-lg border border-slate-300 px-5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
                                >
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                @endcan

                {{-- Tabel cabang --}}
                <div class="overflow-hidden rounded-xl bg-white shadow-sm">

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">

                            <thead class="bg-slate-50 text-slate-600">
                                <tr>
                                    <th class="px-6 py-4">No.</th>
                                    <th class="px-6 py-4">Kode Cabang</th>
                                    <th class="px-6 py-4">Nama Cabang</th>
                                    <th class="px-6 py-4">Alamat</th>
                                    <th class="px-6 py-4">Kota</th>
                                    <th class="px-6 py-4">Telepon</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                @forelse ($branches as $branch)
                                    <tr class="hover:bg-slate-50">

                                        <td class="px-6 py-4">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-6 py-4 font-medium text-slate-800">
                                            {{ $branch->code }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $branch->name }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $branch->address ?: '-' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $branch->city }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $branch->phone ?: '-' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($branch->is_active)
                                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-600">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @can('branches.edit')
                                                <a
                                                    href="{{ route('branches.edit', $branch->id) }}"
                                                    class="inline-flex rounded-lg bg-amber-500 px-3 py-2 text-sm font-medium text-white hover:bg-amber-600"
                                                >
                                                    Edit
                                                </a>
                                            @endcan
                                            @can('branches.edit')
                                                <form
                                                    action="{{ route('branches.toggle-status', $branch->id) }}"
                                                    method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Apakah kamu yakin ingin mengubah status cabang ini?')"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    @if ($branch->is_active)
                                                        <button
                                                            type="submit"
                                                            class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700"
                                                        >
                                                            Nonaktifkan
                                                        </button>
                                                    @else
                                                        <button
                                                            type="submit"
                                                            class="rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700"
                                                        >
                                                            Aktifkan
                                                        </button>
                                                    @endif
                                                </form>
                                            @endcan
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center text-slate-500">
                                            Belum ada data cabang.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-slate-100 px-6 py-4 text-sm text-slate-500">
                        Total cabang: {{ $branches->count() }}
                    </div>

                </div>

            </div>

        </main>

    </div>

</div>
@endsection