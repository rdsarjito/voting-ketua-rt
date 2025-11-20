<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-500">{{ now()->format('l, d F Y') }}</p>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ auth()->user()->role === 'admin' ? 'Control Center' : 'Progress Pemilihan' }}
                </h2>
            </div>
            <a href="{{ route('vote.categories') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white shadow hover:bg-blue-700 transition">
                <span class="text-sm font-semibold">Lihat Kategori</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto space-y-8 px-4 sm:px-6 lg:px-8">
            @if($mode === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    @foreach($metrics as $metric)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                            <p class="text-sm text-gray-500">{{ $metric['label'] }}</p>
                            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ number_format($metric['value']) }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $metric['detail'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    <div class="xl:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Tingkat Partisipasi</p>
                                    <h3 class="text-3xl font-semibold text-gray-900">{{ $turnoutRate ?? 0 }}%</h3>
                                    <p class="text-xs text-gray-400 mt-1">Persentase pemilih aktif yang sudah memberikan suara</p>
                                </div>
                                <div class="relative h-28 w-28">
                                    <svg viewBox="0 0 36 36" class="h-full w-full">
                                        <path class="text-gray-200 stroke-current" stroke-width="4" fill="none" d="M18 2.0845
                                            a 15.9155 15.9155 0 0 1 0 31.831
                                            a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                        <path class="text-blue-600 stroke-current" stroke-width="4" stroke-linecap="round" fill="none"
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

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Distribusi Suara per Kategori</p>
                                    <h3 class="text-xl font-semibold text-gray-900">Snapshot Real-time</h3>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full bg-blue-50 text-blue-600 font-semibold">Live</span>
                            </div>
                            <canvas id="categoryChart" height="160"></canvas>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Suara Masuk 10 Hari Terakhir</p>
                                    <h3 class="text-xl font-semibold text-gray-900">Traffic Aktivitas</h3>
                                </div>
                            </div>
                            <canvas id="turnoutChart" height="160"></canvas>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <p class="text-sm text-gray-500 mb-4">Jadwal Voting</p>
                            <ul class="space-y-4">
                                @forelse($upcomingWindows as $window)
                                    <li class="flex items-start gap-3">
                                        <span class="w-2 h-2 rounded-full mt-2 {{ $window->isVotingOpen() ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
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
                            <a href="{{ route('admin.categories.index') }}" class="mt-4 inline-flex text-sm text-blue-600 hover:underline">Kelola Jadwal</a>
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
                                    <div class="h-3 rounded-full bg-blue-600" style="width: {{ $progress }}%"></div>
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
                            <a href="{{ route('vote.categories') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white shadow hover:bg-blue-700">
                                Mulai / lanjutkan memilih
                            </a>
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
                            backgroundColor: 'rgba(59, 130, 246, 0.7)',
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
