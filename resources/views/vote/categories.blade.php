<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1.5">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Kategori Voting
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Pilih salah satu kategori di bawah untuk melihat dan memberikan suara kepada kandidat.
                </p>
            </div>
            <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Voting dibuka
                </span>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-800">
                    <span class="w-2 h-2 rounded-full bg-gray-400 dark:bg-gray-500"></span>
                    Voting ditutup
                </span>
                <span class="hidden sm:inline text-gray-400">•</span>
                <span>{{ $categories->count() }} Kategori</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-4">
        @if($categories->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 text-center">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">
                    Belum ada kategori voting
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                    Kategori akan muncul di sini setelah dibuat oleh admin.
                </p>
                <p class="text-[11px] text-gray-400 dark:text-gray-500">
                    Hubungi admin jika Anda merasa seharusnya sudah ada kategori yang aktif.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
                @foreach($categories as $category)
                    <a href="{{ route('vote.category.show', $category) }}"
                       class="group block bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-indigo-400 dark:hover:border-indigo-500 shadow-sm hover:shadow-md transition-all duration-150">
                        <div class="p-4 space-y-3">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                                        {{ $category->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $category->candidates_count }} kandidat
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium
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
                                <span class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-medium bg-gray-50 text-gray-700 dark:bg-gray-700 dark:text-gray-200 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
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


