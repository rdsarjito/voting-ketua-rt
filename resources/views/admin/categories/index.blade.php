<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kategori</h2>
    </x-slot>

    <div class="mb-4">
        <a href="{{ route('admin.categories.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Tambah</a>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="py-2">Nama</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Periode Voting</th>
                    <th class="py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr class="border-t border-gray-700">
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
                    <td class="py-2 space-x-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600" onclick="return confirm('Hapus kategori?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
</x-app-layout>


