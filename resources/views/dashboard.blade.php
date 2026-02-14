<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-emerald-600 font-semibold">{{ now()->format('l, d F Y') }}</p>
                <h2 class="font-bold text-3xl bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent leading-tight">
                    {{ auth()->user()->role === 'admin' ? '🎯 Control Center' : '📊 Progress Pemilihan' }}
                </h2>
            </div>
            <a href="{{ route('vote.categories') }}" class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200">
                <span class="text-sm font-semibold">🗳️ Lihat Kategori</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto space-y-8 px-4 sm:px-6 lg:px-8">
            @if($mode === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    @foreach($metrics as $metric)
                        <div class="bg-gradient-to-br from-white to-emerald-50 rounded-2xl shadow-lg border border-emerald-100 p-6 hover:shadow-xl transition-shadow duration-200">
                            <p class="text-sm text-emerald-600 font-semibold">{{ $metric['label'] }}</p>
                            <p class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mt-2">{{ number_format($metric['value']) }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $metric['detail'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    <div class="xl:col-span-2 space-y-6">
                        <div class="bg-gradient-to-br from-white to-teal-50 rounded-2xl shadow-lg border border-teal-100 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-teal-600 font-semibold">Tingkat Partisipasi</p>
                                    <h3 class="text-4xl font-bold bg-gradient-to-r from-teal-600 to-emerald-600 bg-clip-text text-transparent">{{ $turnoutRate ?? 0 }}%</h3>
                                    <p class="text-xs text-gray-500 mt-1">Persentase pemilih aktif yang sudah memberikan suara</p>
                                </div>
                                <div class="relative h-28 w-28">
                                    <svg viewBox="0 0 36 36" class="h-full w-full">
                                        <path class="text-gray-200 stroke-current" stroke-width="4" fill="none" d="M18 2.0845
                                            a 15.9155 15.9155 0 0 1 0 31.831
                                            a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                        <path class="text-teal-600 stroke-current" stroke-width="4" stroke-linecap="round" fill="none"
                                            stroke-dasharray="{{ $turnoutRate ?? 0 }}, 100"
                                            d="M18 2.0845
                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-lg font-semibold text-gray-900">{{ $turnoutRate ?? 0 }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg border border-blue-100 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-sm text-blue-600 font-semibold">📊 Distribusi Suara per Kategori</p>
                                    <h3 class="text-xl font-bold text-gray-900">Snapshot Real-time</h3>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 text-white font-semibold shadow">🔴 Live</span>
                            </div>
                            <canvas id="categoryChart" height="160"></canvas>
                        </div>

                        <div class="bg-gradient-to-br from-white to-emerald-50 rounded-2xl shadow-lg border border-emerald-100 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-sm text-emerald-600 font-semibold">📈 Suara Masuk 10 Hari Terakhir</p>
                                    <h3 class="text-xl font-bold text-gray-900">Traffic Aktivitas</h3>
                                </div>
                            </div>
                            <canvas id="turnoutChart" height="160"></canvas>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-gradient-to-br from-white to-amber-50 rounded-2xl shadow-lg border border-amber-100 p-6">
                            <p class="text-sm text-amber-600 font-semibold mb-4">📅 Jadwal Voting</p>
                            <ul class="space-y-4">
                                @forelse($upcomingWindows as $window)
                                    <li class="flex items-start gap-3">
                                        <span class="w-2 h-2 rounded-full mt-2 {{ $window->isVotingOpen() ? 'bg-green-500 animate-pulse' : 'bg-gray-300' }}"></span>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $window->name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $window->voting_start ? $window->voting_start->format('d M H:i') : 'Belum dijadwalkan' }}
                                                —
                                                {{ $window->voting_end ? $window->voting_end->format('d M H:i') : 'Tanpa batas' }}
                                            </p>
                                        </div>
                                    </li>
                                @empty
                                    <p class="text-sm text-gray-400">Belum ada jadwal aktif.</p>
                                @endforelse
                            </ul>
                            <a href="{{ route('admin.categories.index') }}" class="mt-4 inline-flex text-sm font-semibold text-emerald-600 hover:text-teal-600 transition">✨ Kelola Jadwal</a>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <p class="text-sm text-gray-500 mb-4">Performa Kandidat</p>
                            <div class="space-y-4">
                                @forelse($topCandidates as $candidate)
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $candidate->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $candidate->category?->name }}</p>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $candidate->votes_count }} suara</span>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400">Belum ada kandidat dengan suara.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <p class="text-sm text-gray-500 mb-4">Aktivitas Terbaru</p>
                            <div class="space-y-4 max-h-72 overflow-y-auto">
                                @forelse($recentLogs as $log)
                                    <div class="border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                        <p class="font-medium text-gray-900">{{ ucfirst($log->action) }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $log->user?->name ?? 'System' }} • {{ $log->created_at->diffForHumans() }}
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $log->route }} ({{ $log->method }})</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400">Belum ada aktivitas terekam.</p>
                                @endforelse
                            </div>
                            <a href="{{ route('admin.audit-logs.index') }}" class="mt-4 inline-flex text-sm text-blue-600 hover:underline">Lihat Semua</a>
                        </div>
                    </div>
                </div>
            @else
                @php
                    $progress = ($userOverview['totalCategories'] ?? 0) > 0
                        ? round(($userOverview['votedCategories'] / $userOverview['totalCategories']) * 100)
                        : 0;
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <p class="text-sm text-gray-500">Status Voting Anda</p>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-4 gap-6">
                            <div>
                                <h3 class="text-4xl font-semibold text-gray-900">{{ $progress }}%</h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $userOverview['votedCategories'] ?? 0 }} dari {{ $userOverview['totalCategories'] ?? 0 }} kategori sudah dipilih
                                </p>
                            </div>
                            <div class="flex-1">
                                <div class="w-full bg-gray-100 rounded-full h-3">
                                    <div class="h-3 rounded-full bg-emerald-600" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl border border-gray-100">
                                <p class="text-sm text-gray-500">Kategori Tersisa</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $userOverview['pendingCategories'] ?? 0 }}</p>
                            </div>
                            <div class="p-4 rounded-xl border border-gray-100">
                                <p class="text-sm text-gray-500">Deadline Terdekat</p>
                                @if(($userOverview['nextDeadline'] ?? null))
                                    <p class="text-lg font-semibold text-gray-900">{{ $userOverview['nextDeadline']->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $userOverview['nextDeadline']->voting_end?->format('d M H:i') }}</p>
                                @else
                                    <p class="text-lg font-semibold text-gray-900">Belum ada</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('vote.categories') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 text-white shadow hover:bg-emerald-700">
                                Mulai / lanjutkan memilih
                            </a>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <p class="text-sm text-gray-500">Kategori Aktif</p>
                                <a href="{{ route('vote.categories') }}" class="text-xs text-emerald-600 hover:underline">Lihat Semua</a>
                            </div>
                            <div class="space-y-3 max-h-80 overflow-y-auto">
                                @forelse($activeCategories ?? [] as $category)
                                    <div class="border border-gray-200 rounded-lg p-3 hover:border-emerald-300 transition-colors">
                                        <div class="flex items-start justify-between gap-2 mb-2">
                                            <div class="flex-1">
                                                <p class="font-semibold text-sm text-gray-900">{{ $category['name'] }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    {{ $category['candidates_count'] }} kandidat
                                                    @if($category['voting_end'])
                                                        • Tutup: {{ \Carbon\Carbon::parse($category['voting_end'])->format('d M H:i') }}
                                                    @endif
                                                </p>
                                            </div>
                                            @if($category['has_voted'])
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                    Sudah Vote
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                                    Belum Vote
                                                </span>
                                            @endif
                                        </div>
                                        <a 
                                            href="{{ route('vote.category.show', $category['id']) }}"
                                            class="inline-flex items-center justify-center w-full mt-2 px-3 py-1.5 text-xs font-medium rounded-lg border border-emerald-600 text-emerald-600 hover:bg-emerald-50 transition-colors"
                                        >
                                            {{ $category['has_voted'] ? 'Lihat Detail' : 'Vote Sekarang' }}
                                        </a>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400 text-center py-4">Tidak ada kategori aktif saat ini.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <p class="text-sm text-gray-500 mb-4">Suara Terakhir</p>
                            <div class="space-y-4 max-h-80 overflow-y-auto">
                                @forelse($userRecentVotes as $vote)
                                    <div class="border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                        <p class="font-semibold text-gray-900">{{ $vote->candidate->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $vote->candidate->category->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $vote->created_at->diffForHumans() }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400">Anda belum memilih kandidat.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($mode === 'admin')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const categoryChartData = @json($categoryChart ?? ['labels' => [], 'votes' => []]);
            const turnoutChartData = @json($turnoutTrend ?? ['labels' => [], 'values' => []]);

            const categoryCtx = document.getElementById('categoryChart')?.getContext('2d');
            if (categoryCtx) {
                new Chart(categoryCtx, {
                    type: 'bar',
                    data: {
                        labels: categoryChartData.labels,
                        datasets: [{
                            label: 'Total Suara',
                            data: categoryChartData.votes,
                            backgroundColor: 'rgba(16, 185, 129, 0.7)',
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }

            const turnoutCtx = document.getElementById('turnoutChart')?.getContext('2d');
            if (turnoutCtx) {
                new Chart(turnoutCtx, {
                    type: 'line',
                    data: {
                        labels: turnoutChartData.labels,
                        datasets: [{
                            label: 'Suara per Hari',
                            data: turnoutChartData.values,
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgba(16, 185, 129, 0.15)',
                            tension: 0.35,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true, ticks: { precision: 0 } }
                        }
                    }
                });
            }
        </script>
    @endif
</x-app-layout>
