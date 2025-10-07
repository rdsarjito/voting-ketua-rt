<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kategori Voting</h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($categories as $category)
        <a href="{{ route('vote.category.show', $category) }}" class="block p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-lg font-semibold">{{ $category->name }}</div>
            <div class="text-sm text-gray-600">{{ $category->candidates_count }} kandidat</div>
        </a>
        @endforeach
    </div>
</x-app-layout>


