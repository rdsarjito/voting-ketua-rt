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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($category->candidates as $candidate)
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            @if($candidate->photo)
                <img src="{{ asset('storage/'.$candidate->photo) }}" class="h-32 object-cover mb-2" />
            @endif
            <div class="text-lg font-semibold">{{ $candidate->name }}</div>
            <div class="mt-2">
                <div class="font-semibold">Visi</div>
                <div class="text-sm">{{ $candidate->vision }}</div>
            </div>
            <div class="mt-2">
                <div class="font-semibold">Misi</div>
                <div class="text-sm">{{ $candidate->mission }}</div>
            </div>

            <form method="POST" action="{{ route('vote.store', $candidate) }}" class="mt-4">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->id }}" />
                <button class="px-3 py-2 rounded {{ $existingVote ? 'bg-gray-300 text-gray-700 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 text-white' }}" {{ $existingVote ? 'disabled' : '' }} onclick="return {{ $existingVote ? 'false' : 'confirm(\'Pilih '.$candidate->name.'?\')' }}">{{ $existingVote ? 'Sudah memilih' : 'Pilih' }}</button>
            </form>
        </div>
        @endforeach
    </div>
</x-app-layout>


