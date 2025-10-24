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
    </div>
</x-app-layout>