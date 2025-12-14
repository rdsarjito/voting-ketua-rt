<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $category->name }}</h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ $category->candidates->count() }} Kandidat
            </span>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6">
        <!-- Alert Messages -->
        @if(session('status'))
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border-l-4 border-emerald-500 rounded-r-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-emerald-800 dark:text-emerald-200 font-medium">{{ session('status') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-r-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <p class="text-red-800 dark:text-red-200 font-medium">{{ $errors->first() }}</p>
            </div>
        @endif

        @if($existingVote)
            <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 rounded-r-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <p class="text-amber-800 dark:text-amber-200 font-medium">Anda sudah memilih kandidat di kategori ini.</p>
            </div>
        @endif

        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-semibold">Periode Voting</span>
                    </div>
                    <div class="text-base text-gray-900 dark:text-white">
                        {{ $category->voting_start ? $category->voting_start->format('d M Y, H:i') : 'Belum ditentukan' }}
                        <span class="mx-2 text-gray-400">—</span>
                        {{ $category->voting_end ? $category->voting_end->format('d M Y, H:i') : 'Belum ditentukan' }}
                    </div>
                </div>
                <a href="{{ route('vote.category.compare', $category) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all transform hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Bandingkan Kandidat
                </a>
            </div>
        </div>

        <!-- Search Box -->
        <div class="mb-6">
            <form method="GET" action="{{ route('vote.category.show', $category) }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $searchQuery ?? '' }}"
                            placeholder="Cari kandidat berdasarkan nama, visi, atau misi..." 
                            class="w-full px-4 py-3 pl-11 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        />
                        <svg class="absolute left-3.5 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-sm hover:shadow-md"
                    >
                        Cari
                    </button>
                    @if($searchQuery ?? false)
                        <a 
                            href="{{ route('vote.category.show', $category) }}"
                            class="px-5 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium"
                        >
                            Reset
                        </a>
                    @endif
                </div>
                @if($searchQuery ?? false)
                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Menampilkan <strong class="text-gray-900 dark:text-white">{{ $category->candidates->count() }}</strong> hasil untuk "<strong class="text-gray-900 dark:text-white">{{ $searchQuery }}</strong>"
                    </p>
                @endif
            </form>
        </div>

        <!-- Candidates Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($category->candidates as $candidate)
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-sm hover:shadow-lg hover:border-blue-400 dark:hover:border-blue-600 transition-all duration-300 transform hover:-translate-y-1">
                <!-- Photo -->
                <div class="text-center mb-5">
                    @if($candidate->photo)
                        <img src="{{ asset('storage/'.$candidate->photo) }}" class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-gray-100 dark:border-gray-700 shadow-md" />
                    @else
                        <div class="w-24 h-24 rounded-full mx-auto bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center shadow-md border-4 border-gray-100 dark:border-gray-700">
                            <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Name -->
                <h3 class="text-xl font-bold text-center text-gray-900 dark:text-white mb-4">{{ $candidate->name }}</h3>

                <!-- Vision & Mission -->
                <div class="space-y-4 text-sm mb-6">
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 border-l-3 border-blue-500">
                        <div class="font-semibold text-blue-700 dark:text-blue-300 mb-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Visi
                        </div>
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed text-xs">{{ Str::limit($candidate->vision, 120) }}</div>
                    </div>
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-3 border-l-3 border-indigo-500">
                        <div class="font-semibold text-indigo-700 dark:text-indigo-300 mb-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Misi
                        </div>
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed text-xs">{{ Str::limit($candidate->mission, 120) }}</div>
                    </div>
                </div>

                <!-- Action -->
                <div class="mt-6">
                    @if(!$existingVote && $category->isVotingOpen())
                        <form method="POST" action="{{ route('vote.store', $candidate) }}">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $category->id }}" />
                            <button class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white py-3 px-4 rounded-lg text-sm font-semibold transition-all shadow-md hover:shadow-lg transform hover:scale-[1.02] active:scale-[0.98]" onclick="return confirm('Pilih {{ $candidate->name }}?')">
                                Pilih Kandidat
                            </button>
                        </form>
                    @elseif(!$category->isVotingOpen())
                        <div class="w-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 py-3 px-4 rounded-lg text-sm text-center font-medium">
                            <svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Voting ditutup
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if($category->candidates->isEmpty())
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="mx-auto w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    @if($searchQuery ?? false)
                        Tidak ada kandidat yang ditemukan
                    @else
                        Belum ada kandidat
                    @endif
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                    @if($searchQuery ?? false)
                        Coba gunakan kata kunci lain atau 
                        <a href="{{ route('vote.category.show', $category) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">reset pencarian</a>
                    @else
                        Kandidat akan muncul setelah ditambahkan oleh admin
                    @endif
                </p>
            </div>
        @endif
    </div>
</x-app-layout>