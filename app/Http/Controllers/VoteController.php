<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Category;
use App\Models\Vote;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VoteController extends Controller
{
    public function categories(): View
    {
        $categories = Category::withCount('candidates')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('vote.categories', compact('categories'));
    }

    public function showCategory(Category $category): View
    {
        if (!$category->is_active) {
            abort(404, 'Kategori tidak aktif');
        }
        
        $category->load('candidates');
        $existingVote = Vote::where('user_id', auth()->id())
            ->where('category_id', $category->id)
            ->first();
        return view('vote.category', compact('category', 'existingVote'));
    }

    public function store(Request $request, Candidate $candidate): RedirectResponse
    {
        $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ]);

        $userId = $request->user()->id;
        $categoryId = (int) $request->input('category_id');
        $category = Category::find($categoryId);

        // Check if voting is open for this category
        if (!$category->isVotingOpen()) {
            return back()->withErrors(['vote' => 'Voting untuk kategori ini belum dibuka atau sudah ditutup.']);
        }

        $alreadyVoted = Vote::where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->exists();

        if ($alreadyVoted) {
            return back()->withErrors(['vote' => 'Anda sudah melakukan voting di kategori ini.']);
        }

        if ($candidate->category_id !== $categoryId) {
            return back()->withErrors(['vote' => 'Kandidat tidak sesuai dengan kategori.']);
        }

        Vote::create([
            'user_id' => $userId,
            'candidate_id' => $candidate->id,
            'category_id' => $categoryId,
        ]);

        return back()->with('status', 'Vote berhasil disimpan.');
    }

    public function results(): View
    {
        $results = Vote::selectRaw('candidate_id, count(*) as total')
            ->groupBy('candidate_id')
            ->with('candidate:id,name,category_id', 'candidate.category:id,name')
            ->get();

        return view('admin.results', compact('results'));
    }

    public function exportResults(): StreamedResponse
    {
        $filename = 'voting_results_'.now()->format('Ymd_His').'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Category', 'Candidate', 'Total Votes']);

            $rows = Vote::selectRaw('candidate_id, count(*) as total')
                ->groupBy('candidate_id')
                ->with('candidate:id,name,category_id', 'candidate.category:id,name')
                ->get();

            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->candidate->category->name ?? '-',
                    $row->candidate->name ?? '-',
                    (int) $row->total,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
