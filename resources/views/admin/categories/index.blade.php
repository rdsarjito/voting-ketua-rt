<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kategori</h2>
    </x-slot>

    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('admin.categories.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah</a>
        <form method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari kategori..." class="border rounded p-2 bg-gray-100 dark:bg-gray-700" />
            @if($search)
                <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-100 dark:text-gray-200 dark:border-gray-600">Reset</a>
            @endif
            <button class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cari</button>
        </form>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
        @if($search)
            <p class="mb-3 text-sm text-gray-600 dark:text-gray-300">
                Menampilkan hasil untuk: <span class="font-semibold">"{{ $search }}"</span>
            </p>
        @endif
        <table class="w-full text-left text-sm">
            <thead>
                <tr>
                    <th class="py-2">Nama</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Periode Voting</th>
                    <th class="py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="py-2">{{ $category->name }}</td>
                    <td class="py-2">
                        @if($category->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Aktif</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Nonaktif</span>
                        @endif
                    </td>
                    <td class="py-2 text-sm">
                        @if($category->voting_start && $category->voting_end)
                            {{ $category->voting_start->format('d/m/Y H:i') }} - {{ $category->voting_end->format('d/m/Y H:i') }}
                        @elseif($category->voting_start)
                            Mulai: {{ $category->voting_start->format('d/m/Y H:i') }}
                        @elseif($category->voting_end)
                            Berakhir: {{ $category->voting_end->format('d/m/Y H:i') }}
                        @else
                            Selamanya
                        @endif
                    </td>
                    <td class="py-2 space-x-2 text-right">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="px-2 py-1 rounded bg-blue-100 text-blue-700 hover:bg-blue-200">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="px-2 py-1 rounded bg-red-100 text-red-700 hover:bg-red-200" onclick="return confirm('Hapus kategori?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-8 text-center text-gray-500 dark:text-gray-400">
                        Tidak ada kategori yang cocok dengan pencarian.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
</x-app-layout>


