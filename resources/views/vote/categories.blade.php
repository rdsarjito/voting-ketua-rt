<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1.5">
            <div>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent leading-tight">
                    🗳️ Kategori Voting
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 font-medium">
                    Pilih salah satu kategori di bawah untuk melihat dan memberikan suara kepada kandidat.
                </p>
            </div>
            <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600 dark:text-gray-300">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 font-semibold">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    Voting dibuka
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-800 font-semibold">
                    <span class="w-2 h-2 rounded-full bg-gray-400 dark:bg-gray-500"></span>
                    Voting ditutup
                </span>
                <span class="hidden sm:inline text-gray-400">•</span>
                <span class="font-bold text-indigo-600">{{ $categories->count() }} Kategori</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="mb-6">
            <form method="GET" action="{{ route('vote.categories') }}" class="flex gap-3">
                <div class="flex-1 relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $searchQuery ?? '' }}"
                        placeholder="Cari kategori..." 
                        class="w-full px-4 py-3 pl-11 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    />
                    <svg class="absolute left-3.5 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button 
                    type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl hover:scale-105"
                >
                    🔍 Cari
                </button>
                @if($searchQuery ?? false)
                    <a 
                        href="{{ route('vote.categories') }}"
                        class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium"
                    >
                        Reset
                    </a>
                @endif
            </form>
            @if($searchQuery ?? false)
                <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan {{ $categories->count() }} hasil untuk "<strong>{{ $searchQuery }}</strong>"
                </p>
            @endif
        </div>

        @if($categories->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-12 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 mb-4">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    Belum ada kategori voting
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Kategori akan muncul di sini setelah ditambahkan oleh admin.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('vote.category.show', $category) }}"
                       class="group block bg-gradient-to-br from-white to-indigo-50 dark:from-gray-800 dark:to-gray-750 rounded-2xl shadow-lg border border-indigo-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-xl hover:scale-105 hover:border-indigo-300 dark:hover:border-indigo-600">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xl font-bold bg-gradient-to-r from-indigo-700 to-purple-700 bg-clip-text text-transparent">
                                {{ $category->name }}
                            </h3>
                            @if($category->isVotingOpen())
                                <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-md">
                                    ✅ Dibuka
                                </span>
                            @else
                                <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-md">
                                    🔒 Ditutup
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            {{ $category->candidates_count }} kandidat
                        </p>

                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                            <span class="font-medium">Periode:</span>
                            @if($category->voting_start && $category->voting_end)
                                {{ $category->voting_start->format('d M Y H:i') }} - {{ $category->voting_end->format('d M Y H:i') }}
                            @elseif($category->voting_start)
                                Mulai: {{ $category->voting_start->format('d M Y H:i') }}
                            @elseif($category->voting_end)
                                Berakhir: {{ $category->voting_end->format('d M Y H:i') }}
                            @else
                                Selamanya
                            @endif
                        </div>

                        <div class="inline-flex items-center gap-2 text-sm font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent group-hover:gap-3 transition-all">
                            👉 Lihat kandidat
                            <svg class="h-4 w-4 transform transition-transform group-hover:translate-x-1 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>


