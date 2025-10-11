<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::withCount('votes')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,user'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->has('is_active');

        User::create($data);
        return redirect()->route('admin.users.index')->with('status', 'User berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $user->load('votes.candidate.category');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,user'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->has('is_active');

        $user->update($data);
        return redirect()->route('admin.users.index')->with('status', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'Tidak bisa menghapus akun sendiri.']);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'User berhasil dihapus.');
    }

    /**
     * Reset user password
     */
    public function resetPassword(User $user): RedirectResponse
    {
        $newPassword = Str::random(8);
        $user->update(['password' => Hash::make($newPassword)]);
        
        return back()->with('status', "Password berhasil direset. Password baru: {$newPassword}");
    }

    /**
     * Toggle user status (block/unblock)
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'Tidak bisa memblokir akun sendiri.']);
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diblokir' : 'dibuka';
        
        return back()->with('status', "User berhasil {$status}.");
    }
}
