<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::orderBy('name')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'voting_start' => ['nullable', 'date'],
            'voting_end' => ['nullable', 'date', 'after_or_equal:voting_start'],
            'is_active' => ['boolean'],
        ]);
        
        $data['is_active'] = $request->has('is_active');
        
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('status', 'Kategori dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,'.$category->id],
            'voting_start' => ['nullable', 'date'],
            'voting_end' => ['nullable', 'date', 'after_or_equal:voting_start'],
            'is_active' => ['boolean'],
        ]);
        
        $data['is_active'] = $request->has('is_active');
        
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('status', 'Kategori diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('status', 'Kategori dihapus.');
    }
}
