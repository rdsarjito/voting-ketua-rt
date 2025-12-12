<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Candidate;
use App\Models\User;
use App\Models\Vote;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $mode = $user->role === 'admin' ? 'admin' : 'user';

        $baseData = [
            'mode' => $mode,
            'metrics' => [],
            'categoryChart' => ['labels' => [], 'votes' => []],
            'turnoutTrend' => ['labels' => [], 'values' => []],
            'upcomingWindows' => collect(),
            'topCandidates' => collect(),
            'recentLogs' => collect(),
            'userOverview' => [],
            'userRecentVotes' => collect(),
        ];

        if ($mode === 'admin') {
            return view('dashboard', array_merge($baseData, $this->adminData()));
        }

        return view('dashboard', array_merge($baseData, $this->userData($user)));
    }

    protected function adminData(): array
    {
        $totalVoters = User::where('role', 'user')->count();
        $activeVoters = User::where('role', 'user')->where('is_active', true)->count();
        $uniqueVoters = Vote::distinct('user_id')->count('user_id');
        $votesCount = Vote::count();
        $categoriesCount = Category::count();
        $candidatesCount = Candidate::count();

        $turnoutRate = $activeVoters > 0 ? round(($uniqueVoters / $activeVoters) * 100, 1) : 0;

        $categories = Category::withCount(['candidates', 'votes'])
            ->orderBy('name')
            ->get();

        $categoryChart = [
            'labels' => $categories->pluck('name'),
            'votes' => $categories->pluck('votes_count'),
        ];

        $dailyVotes = Vote::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(10))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $turnoutTrend = [
            'labels' => $dailyVotes->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('d M')),
            'values' => $dailyVotes->pluck('total'),
        ];

        $upcomingWindows = Category::where(function ($query) {
            $query->whereNull('voting_end')->orWhere('voting_end', '>=', now());
        })
            ->orderByRaw('COALESCE(voting_start, voting_end) ASC')
            ->take(4)
            ->get();

        $topCandidates = Candidate::withCount('votes')
            ->with('category')
            ->orderByDesc('votes_count')
            ->take(4)
            ->get();

        $recentLogs = AuditLog::with('user')
            ->latest()
            ->take(6)
            ->get();

        return [
            'metrics' => [
                [
                    'label' => 'Total Pemilih',
                    'value' => $totalVoters,
                    'detail' => 'Semua akun berperan sebagai pemilih',
                ],
                [
                    'label' => 'Pemilih Aktif',
                    'value' => $activeVoters,
                    'detail' => 'Status akun aktif saat ini',
                ],
                [
                    'label' => 'Total Suara Masuk',
                    'value' => $votesCount,
                    'detail' => 'Akumulasi lintas kategori',
                ],
                [
                    'label' => 'Kategori Aktif',
                    'value' => $categoriesCount,
                    'detail' => $candidatesCount.' kandidat terdaftar',
                ],
            ],
            'categoryChart' => $categoryChart,
            'turnoutTrend' => $turnoutTrend,
            'turnoutRate' => $turnoutRate,
            'upcomingWindows' => $upcomingWindows,
            'topCandidates' => $topCandidates,
            'recentLogs' => $recentLogs,
        ];
    }

    protected function userData(User $user): array
    {
        $categories = Category::orderBy('name')->get();
        $totalCategories = $categories->count();

        $userVotes = $user->votes()
            ->with(['candidate.category'])
            ->latest()
            ->get();

        $votedCategories = $userVotes->pluck('category_id')->unique()->count();

        $nextDeadline = Category::where('is_active', true)
            ->whereNotNull('voting_end')
            ->where('voting_end', '>=', now())
            ->orderBy('voting_end')
            ->first();

        // Get active categories with voting status
        $activeCategories = Category::where('is_active', true)
            ->withCount('candidates')
            ->get()
            ->filter(function ($category) {
                return $category->isVotingOpen();
            })
            ->map(function ($category) use ($user) {
                $hasVoted = $user->votes()
                    ->where('category_id', $category->id)
                    ->exists();
                
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'candidates_count' => $category->candidates_count,
                    'has_voted' => $hasVoted,
                    'voting_end' => $category->voting_end,
                ];
            })
            ->sortBy('name')
            ->take(5);

        return [
            'userOverview' => [
                'totalCategories' => $totalCategories,
                'votedCategories' => $votedCategories,
                'pendingCategories' => max($totalCategories - $votedCategories, 0),
                'nextDeadline' => $nextDeadline,
            ],
            'userRecentVotes' => $userVotes->take(5),
            'activeCategories' => $activeCategories,
        ];
    }
}

