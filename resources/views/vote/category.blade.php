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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($category->candidates as $candidate)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300">
            <!-- Header with photo -->
            <div class="relative">
                @if($candidate->photo)
                    <img src="{{ asset('storage/'.$candidate->photo) }}" class="w-full h-48 object-cover" />
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                @endif
                <div class="absolute top-4 right-4">
                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium shadow-lg">
                        {{ $category->name }}
                    </span>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $candidate->name }}</h3>
                
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Visi
                        </h4>
                        <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">{{ $candidate->vision }}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Misi
                        </h4>
                        <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">{{ $candidate->mission }}</p>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-6">
                    @if(!$existingVote && $category->isVotingOpen())
                        <form method="POST" action="{{ route('vote.store', $candidate) }}">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $category->id }}" />
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg" onclick="return confirm('Pilih {{ $candidate->name }}?')">
                                Pilih Kandidat Ini
                            </button>
                        </form>
                    @elseif(!$category->isVotingOpen())
                        <div class="w-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 py-3 px-4 rounded-lg text-center font-medium border border-yellow-200 dark:border-yellow-700">
                            Voting belum dibuka atau sudah ditutup
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>