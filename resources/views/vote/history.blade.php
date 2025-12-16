<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Riwayat Voting
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-50 dark:bg-gray-900/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            <!-- Simple Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Vote</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ $stats['total_votes'] }}
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-2.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.523 3.806 10.174 9 11.622 5.194-1.448 9-6.099 9-11.622 0-1.043-.133-2.053-.382-3.016z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Kategori Pernah Diikuti</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ $stats['categories_voted'] }}
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600 dark:text-emerald-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1M5 6h14a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                        </svg>
                    </div>
                </div>

                @if($stats['latest_vote'])
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Vote Terakhir</p>
                            <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $stats['latest_vote']->format('d M Y, H:i') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $stats['latest_vote']->diffForHumans() }}
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center text-amber-600 dark:text-amber-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Belum Ada Vote</p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                Mulai berpartisipasi dalam voting untuk melihat riwayat di sini.
                            </p>
                        </div>
                        <a href="{{ route('vote.categories') }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 text-white hover:bg-indigo-700">
                            Mulai Voting
                        </a>
                    </div>
                @endif
            </div>

            <!-- Filter -->
            @if($filterCategories->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5">
                    <form method="GET" action="{{ route('vote.history') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 text-sm items-end">
                        <div class="space-y-1">
                            <label for="category" class="text-xs font-medium text-gray-600 dark:text-gray-300">Kategori</label>
                            <select
                                id="category"
                                name="category"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Semua</option>
                                @foreach($filterCategories as $category)
                                    <option value="{{ $category->id }}" @selected($selectedCategory == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label for="start_date" class="text-xs font-medium text-gray-600 dark:text-gray-300">Dari tanggal</label>
                            <input
                                id="start_date"
                                type="date"
                                name="start_date"
                                value="{{ $startDate }}"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>

                        <div class="space-y-1">
                            <label for="end_date" class="text-xs font-medium text-gray-600 dark:text-gray-300">Sampai tanggal</label>
                            <input
                                id="end_date"
                                type="date"
                                name="end_date"
                                value="{{ $endDate }}"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>

                        <div class="flex gap-2 md:justify-end">
                            <button
                                type="submit"
                                class="flex-1 md:flex-none px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                            >
                                Terapkan
                            </button>
                            @if($selectedCategory || $startDate || $endDate)
                                <a
                                    href="{{ route('vote.history') }}"
                                    class="flex-1 md:flex-none px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition text-center"
                                >
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            @endif

            <!-- Voting List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="p-4 sm:p-6">
                    @forelse ($votes as $vote)
                        <div class="border-b border-gray-200 dark:border-gray-700 py-4 last:border-0">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        @if($vote->candidate->photo)
                                            <img
                                                src="{{ asset('storage/' . $vote->candidate->photo) }}"
                                                alt="{{ $vote->candidate->name }}"
                                                class="h-12 w-12 rounded object-cover"
                                            />
                                        @else
                                            <div class="h-12 w-12 rounded bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                <span class="text-lg font-semibold text-gray-600 dark:text-gray-400">
                                                    {{ strtoupper(substr($vote->candidate->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                                {{ $vote->candidate->name }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $vote->category->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                                {{ $vote->created_at->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <a
                                    href="{{ route('vote.category.show', $vote->category) }}"
                                    class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline"
                                >
                                    Lihat
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada riwayat vote</p>
                            <a
                                href="{{ route('vote.categories') }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700"
                            >
                                Mulai Voting
                            </a>
                        </div>
                    @endforelse
                </div>

                @if($votes->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $votes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
