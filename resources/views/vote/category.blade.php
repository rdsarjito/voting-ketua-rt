<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $category->name }}</h2>
    </x-slot>

    @if(session('status'))
        <div class="p-3 bg-green-600 text-white rounded mb-4">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="p-3 bg-red-600 text-white rounded mb-4">{{ $errors->first() }}</div>
    @endif

    @if($existingVote)
        <div class="p-3 bg-yellow-600 text-white rounded mb-4">Anda sudah memilih kandidat di kategori ini.</div>
    @endif

    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
            <div class="text-sm text-gray-600 dark:text-gray-300">
                <div class="font-semibold">Periode Voting</div>
                <div>
                    {{ $category->voting_start ? $category->voting_start->format('d M Y H:i') : 'Belum ditentukan' }}
                    &mdash;
                    {{ $category->voting_end ? $category->voting_end->format('d M Y H:i') : 'Belum ditentukan' }}
                </div>
            </div>
            <a href="{{ route('vote.category.compare', $category) }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow hover:shadow-md transition">
                Bandingkan Kandidat
            </a>
        </div>

        <!-- Search Box -->
        <div class="mb-6">
            <form method="GET" action="{{ route('vote.category.show', $category) }}" class="flex gap-2">
                <div class="flex-1 relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $searchQuery ?? '' }}"
                        placeholder="Cari kandidat berdasarkan nama, visi, atau misi..." 
                        class="w-full px-4 py-2.5 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button 
                    type="submit"
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors"
                >
                    Cari
                </button>
                @if($searchQuery ?? false)
                    <a 
                        href="{{ route('vote.category.show', $category) }}"
                        class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                    >
                        Reset
                    </a>
                @endif
            </form>
            @if($searchQuery ?? false)
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan {{ $category->candidates->count() }} hasil untuk "<strong>{{ $searchQuery }}</strong>"
                </p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($category->candidates as $candidate)
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
                <!-- Photo -->
                <div class="text-center mb-4">
                    @if($candidate->photo)
                        <img src="{{ asset('storage/'.$candidate->photo) }}" class="w-20 h-20 rounded-full mx-auto object-cover border-2 border-gray-200 dark:border-gray-600" />
                    @else
                        <div class="w-20 h-20 rounded-full mx-auto bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Name -->
                <h3 class="text-lg font-semibold text-center text-gray-900 dark:text-white mb-3">{{ $candidate->name }}</h3>

                <!-- Vision & Mission -->
                <div class="space-y-3 text-sm">
                    <div>
                        <div class="font-medium text-gray-700 dark:text-gray-300 mb-1">Visi:</div>
                        <div class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ Str::limit($candidate->vision, 100) }}</div>
                    </div>
                    <div>
                        <div class="font-medium text-gray-700 dark:text-gray-300 mb-1">Misi:</div>
                        <div class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ Str::limit($candidate->mission, 100) }}</div>
                    </div>
                </div>

                <!-- Action -->
                <div class="mt-4">
                    @if(!$existingVote && $category->isVotingOpen())
                        <form method="POST" action="{{ route('vote.store', $candidate) }}">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $category->id }}" />
                            <button class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded text-sm font-medium transition-colors" onclick="return confirm('Pilih {{ $candidate->name }}?')">
                                Pilih
                            </button>
                        </form>
                    @elseif(!$category->isVotingOpen())
                        <div class="w-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 py-2 px-4 rounded text-sm text-center">
                            Voting ditutup
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if($category->candidates->isEmpty())
            <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">
                    @if($searchQuery ?? false)
                        Tidak ada kandidat yang ditemukan
                    @else
                        Belum ada kandidat
                    @endif
                </p>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    @if($searchQuery ?? false)
                        Coba gunakan kata kunci lain atau <a href="{{ route('vote.category.show', $category) }}" class="text-blue-600 hover:underline">reset pencarian</a>
                    @else
                        Kandidat akan muncul setelah ditambahkan oleh admin
                    @endif
                </p>
            </div>
        @endif
    </div>
</x-app-layout>