<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $candidates = Candidate::with('category')->latest()->paginate(10);
        return view('admin.candidates.index', compact('candidates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->pluck('name', 'id');
        return view('admin.candidates.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        Candidate::create($data);
        return redirect()->route('admin.candidates.index')->with('status', 'Kandidat dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate): View
    {
        $categories = Category::orderBy('name')->pluck('name', 'id');
        return view('admin.candidates.edit', compact('candidate', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        $candidate->update($data);
        return redirect()->route('admin.candidates.index')->with('status', 'Kandidat diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate): RedirectResponse
    {
        $candidate->delete();
        return redirect()->route('admin.candidates.index')->with('status', 'Kandidat dihapus.');
    }
}
