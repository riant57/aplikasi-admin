<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('code')->get();

        return view('branches.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                'unique:branches,code',
            ],
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'address' => [
                'nullable',
                'string',
            ],
            'city' => [
                'required',
                'string',
                'max:100',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        Branch::create($validated);

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil ditambahkan.');
    }

    
    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                'unique:branches,code,' . $branch->id,
            ],
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'address' => [
                'nullable',
                'string',
            ],
            'city' => [
                'required',
                'string',
                'max:100',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $branch->update($validated);

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil diperbarui.');
    }
    
    public function toggleStatus(Branch $branch)
    {
        $branch->update([
            'is_active' => ! $branch->is_active,
        ]);

        $status = $branch->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('branches.index')
            ->with('success', "Cabang berhasil {$status}.");
    }

}