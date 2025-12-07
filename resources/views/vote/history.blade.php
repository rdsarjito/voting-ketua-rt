<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Riwayat Voting
            </h2>
            <div class="flex items-center gap-2 text-sm">
                <a
                    href="{{ route('vote.categories') }}"
                    class="text-indigo-600 dark:text-indigo-400 hover:underline"
                >
                    Vote Baru
                </a>
                <span class="text-gray-300 dark:text-gray-600">|</span>
                <a
                    href="{{ route('vote.history.export') }}"
                    class="text-gray-600 dark:text-gray-300 hover:underline flex items-center gap-1"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12v7a1 1 0 001 1h14a1 1 0 001-1v-7M4 12l3.029-3.029a3 3 0 014.242 0L14.3 12l.471.471a3 3 0 004.242 0L20 11.485" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v12" />
                    </svg>
                    Unduh CSV
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Simple Stats -->
            <div class="mb-6 flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                <span>Total: <strong class="text-gray-900 dark:text-white">{{ $stats['total_votes'] }}</strong> vote</span>
                <span>•</span>
                <span>Kategori: <strong class="text-gray-900 dark:text-white">{{ $stats['categories_voted'] }}</strong></span>
            </div>

            <!-- Search Form -->
            <div class="mb-6">
                <form method="GET" action="{{ route('vote.history') }}" class="flex gap-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari berdasarkan nama kandidat atau kategori..."
                        class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                    >
                        Cari
                    </button>
                    @if($search)
                        <a
                            href="{{ route('vote.history') }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                        >
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Voting List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
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
