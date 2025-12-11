<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Category;
use App\Models\Vote;
use App\Mail\VoteConfirmationMail;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Models\AuditLog;
use App\Events\VoteCast;

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

    public function compare(Category $category): View
    {
        if (!$category->is_active) {
            abort(404, 'Kategori tidak aktif');
        }

        $category->load([
            'candidates' => function ($query) {
                $query->withCount('votes')->orderBy('name');
            },
        ]);

        $totalVotes = Vote::where('category_id', $category->id)->count();
        $existingVote = Vote::where('user_id', auth()->id())
            ->where('category_id', $category->id)
            ->first();

        return view('vote.compare', [
            'category' => $category,
            'candidates' => $category->candidates,
            'totalVotes' => $totalVotes,
            'existingVote' => $existingVote,
        ]);
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

        $vote = Vote::create([
            'user_id' => $userId,
            'candidate_id' => $candidate->id,
            'category_id' => $categoryId,
        ]);

        // Audit log
        try {
            AuditLog::create([
                'user_id' => $userId,
                'action' => 'vote',
                'model_type' => Vote::class,
                'model_id' => $vote->id,
                'route' => $request->route()->getName(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'data' => [
                    'category_id' => $categoryId,
                    'candidate_id' => $candidate->id,
                ],
            ]);
        } catch (\Throwable $e) {
            // ignore
        }

        // Send confirmation email
        Mail::to($request->user()->email)->send(new VoteConfirmationMail($request->user(), $candidate));

        // Broadcast real-time notification
        broadcast(new VoteCast($vote, $request->user()));

        return back()->with('status', 'Vote berhasil disimpan. Email konfirmasi telah dikirim.');
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

    /**
     * Display the authenticated user's voting history.
     */
    public function history(Request $request): View
    {
        $user = $request->user();
        $categoryId = $request->query('category');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $start = $startDate ? \Carbon\Carbon::parse($startDate)->startOfDay() : null;
        $end = $endDate ? \Carbon\Carbon::parse($endDate)->endOfDay() : null;

        $filterCategories = Category::whereIn(
            'id',
            $user->votes()->distinct('category_id')->pluck('category_id')
        )->orderBy('name')->get(['id', 'name']);
        
        $votesQuery = Vote::where('user_id', $user->id)
            ->with(['candidate', 'category'])
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($start, function ($query) use ($start) {
                $query->where('created_at', '>=', $start);
            })
            ->when($end, function ($query) use ($end) {
                $query->where('created_at', '<=', $end);
            })
            ->latest();

        $votes = $votesQuery->paginate(15)->withQueryString();

        $stats = [
            'total_votes' => $user->votes()->count(),
            'categories_voted' => $user->votes()->distinct('category_id')->count(),
            'latest_vote' => $user->votes()->latest()->first()?->created_at,
        ];

        return view('vote.history', [
            'votes' => $votes,
            'stats' => $stats,
            'filterCategories' => $filterCategories,
            'selectedCategory' => $categoryId,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
