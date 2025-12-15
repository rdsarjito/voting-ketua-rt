<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Kategori Voting
            </h2>
            <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                {{ $categories->count() }} Kategori
            </span>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-4">
        @if($categories->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-dashed border-gray-300 dark:border-gray-600 p-10 text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6M3 21h18M3 10h18M5 6h14M5 3h14" />
                    </svg>
                </div>
                <p class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                    Belum ada kategori voting
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Kategori akan muncul di sini setelah dibuat oleh admin.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('vote.category.show', $category) }}"
                       class="group relative block bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 overflow-hidden">
                        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>

                        <div class="p-5 space-y-3">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                                        {{ $category->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $category->candidates_count }} kandidat
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium
                                    @if($category->isVotingOpen())
                                        bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300
                                    @else
                                        bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                                    @endif">
                                    @if($category->isVotingOpen())
                                        Voting dibuka
                                    @else
                                        Voting ditutup
                                    @endif
                                </span>
                            </div>

                            <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @if($category->voting_start || $category->voting_end)
                                    <span>
                                        {{ $category->voting_start ? $category->voting_start->format('d M') : 'Belum ditentukan' }}
                                        –
                                        {{ $category->voting_end ? $category->voting_end->format('d M') : 'Belum ditentukan' }}
                                    </span>
                                @else
                                    <span>Periode belum ditentukan</span>
                                @endif
                            </div>

                            <div class="pt-1">
                                <span class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-200 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                    Lihat kandidat
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>


