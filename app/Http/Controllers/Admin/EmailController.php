<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\VotingReminderMail;
use App\Mail\VotingResultsMail;
use App\Models\Category;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('is_active', true)->get();
        $users = User::where('role', 'user')->where('is_active', true)->get();
        
        return view('admin.emails.index', compact('categories', 'users'));
    }

    public function sendReminder(Request $request): RedirectResponse
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
        ]);

        $category = Category::find($request->category_id);
        $users = User::whereIn('id', $request->user_ids)->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new VotingReminderMail($user, $category));
        }

        return back()->with('status', "Reminder berhasil dikirim ke {$users->count()} user untuk kategori {$category->name}.");
    }

    public function sendResults(Request $request): RedirectResponse
    {
        $request->validate([
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
        ]);

        $users = User::whereIn('id', $request->user_ids)->get();
        $results = Vote::selectRaw('candidate_id, count(*) as total')
            ->groupBy('candidate_id')
            ->with('candidate:id,name,category_id', 'candidate.category:id,name')
            ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new VotingResultsMail($user, $results));
        }

        return back()->with('status', "Hasil voting berhasil dikirim ke {$users->count()} user.");
    }
}
