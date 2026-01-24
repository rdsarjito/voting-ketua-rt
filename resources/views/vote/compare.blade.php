<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">🔍 Perbandingan Kandidat</p>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent leading-tight">
                    {{ $category->name }}
                </h2>
            </div>
            <a href="{{ route('vote.category.show', $category) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition-all">
                ← Kembali ke daftar kandidat
            </a>
        </div>
    </x-slot>

    @php
        $leaderVotes = $candidates->max('votes_count') ?? 0;
        $totalVotes = max($totalVotes, 0);
    @endphp

    <div class="max-w-6xl mx-auto space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-white to-indigo-50 dark:from-gray-800 dark:to-gray-750 rounded-2xl border border-indigo-100 dark:border-gray-700 p-6 shadow-lg hover:shadow-xl transition-shadow">
                <p class="text-sm text-indigo-600 dark:text-indigo-400 mb-1 font-bold">👥 Total Kandidat</p>
                <p class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">{{ $candidates->count() }}</p>
            </div>
            <div class="bg-gradient-to-br from-white to-emerald-50 dark:from-gray-800 dark:to-gray-750 rounded-2xl border border-emerald-100 dark:border-gray-700 p-6 shadow-lg hover:shadow-xl transition-shadow">
                <p class="text-sm text-emerald-600 dark:text-emerald-400 mb-1 font-bold">🗳️ Total Vote Masuk</p>
                <p class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">{{ number_format($totalVotes) }}</p>
            </div>
            <div class="bg-gradient-to-br from-white to-amber-50 dark:from-gray-800 dark:to-gray-750 rounded-2xl border border-amber-100 dark:border-gray-700 p-6 shadow-lg hover:shadow-xl transition-shadow">
                <p class="text-sm text-amber-600 dark:text-amber-400 mb-1 font-bold">🚦 Status Voting</p>
                <p class="text-xl font-bold {{ $category->isVotingOpen() ? 'text-green-600' : 'text-red-600' }}">
                    {{ $category->isVotingOpen() ? '✅ Sedang Berlangsung' : '🔒 Tidak Aktif' }}
                </p>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-purple-50 dark:from-gray-800 dark:to-gray-750 rounded-3xl border border-purple-100 dark:border-gray-700 p-8 shadow-xl">
            <h3 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-6">⭐ Highlight Kandidat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($candidates as $candidate)
                    @php
                        $isLeader = $candidate->votes_count === $leaderVotes && $leaderVotes > 0;
                        $isUserChoice = $existingVote && $existingVote->candidate_id === $candidate->id;
                        $percentage = $totalVotes > 0 ? round(($candidate->votes_count / $totalVotes) * 100, 1) : 0;
                    @endphp
                    <div class="rounded-2xl border {{ $isLeader ? 'border-blue-500' : 'border-gray-200 dark:border-gray-700' }} bg-white dark:bg-gray-900/60 p-6 shadow {{ $isLeader ? 'shadow-blue-100 dark:shadow-blue-900/20' : 'shadow' }}">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $candidate->name }}</h4>
                            <div class="flex gap-2">
                                @if($isLeader)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-md">🏆 Teratas</span>
                                @endif
                                @if($isUserChoice)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-md">✅ Pilihan Anda</span>
                                @endif
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Visi singkat</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-6">{{ Str::limit($candidate->vision, 120) }}</p>
                        <div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <span>{{ $candidate->votes_count }} suara</span>
                                <span>{{ $percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full {{ $isLeader ? 'bg-blue-500' : 'bg-gray-400 dark:bg-gray-500' }}" style="width: {{ $totalVotes > 0 ? $percentage : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-indigo-50 dark:from-gray-800 dark:to-gray-750 rounded-3xl border border-indigo-100 dark:border-gray-700 shadow-xl p-6">
            <h3 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-4">📊 Detail Perbandingan</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-900/40">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Kandidat</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Visi</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Misi</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Total Vote</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900/40">
                        @foreach($candidates as $candidate)
                            @php
                                $percentage = $totalVotes > 0 ? round(($candidate->votes_count / $totalVotes) * 100, 1) : 0;
                                $isUserChoice = $existingVote && $existingVote->candidate_id === $candidate->id;
                            @endphp
                            <tr class="{{ $isUserChoice ? 'bg-blue-50/60 dark:bg-blue-900/20' : '' }}">
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-gray-900 dark:text-white">{{ $candidate->name }}</div>
                                    <div class="text-xs text-gray-500">Kategori: {{ $category->name }}</div>
                                </td>
                                <td class="px-4 py-4 text-gray-700 dark:text-gray-300">{{ Str::limit($candidate->vision, 120) }}</td>
                                <td class="px-4 py-4 text-gray-700 dark:text-gray-300">{{ Str::limit($candidate->mission, 120) }}</td>
                                <td class="px-4 py-4">
                                    <div class="text-gray-900 dark:text-white font-semibold">{{ $candidate->votes_count }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-gray-900 dark:text-white font-semibold">{{ $percentage }}%</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-3">
            <a href="{{ route('vote.category.show', $category) }}" class="inline-flex items-center justify-center px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                Kembali ke Daftar Kandidat
            </a>
            @if(!$existingVote && $category->isVotingOpen())
                <a href="{{ route('vote.category.show', $category) }}#vote-section" class="inline-flex items-center justify-center px-4 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow">
                    Pilih Kandidat Sekarang
                </a>
            @endif
        </div>
    </div>
</x-app-layout>

