<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kategori Voting</h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('vote.category.show', $category) }}" class="block p-5 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition">
            <div class="text-lg font-semibold mb-1">{{ $category->name }}</div>
            <div class="text-xs text-gray-500 mb-2">{{ $category->candidates_count }} kandidat</div>
            <div>
                <span class="inline-block px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs">Lihat kandidat</span>
            </div>
        </a>
        @endforeach
    </div>
</x-app-layout>


