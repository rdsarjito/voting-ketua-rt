<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kandidat</h2>
    </x-slot>

    <div class="mb-4">
        <a href="{{ route('admin.candidates.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Tambah</a>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="py-2">Nama</th>
                    <th class="py-2">Kategori</th>
                    <th class="py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($candidates as $candidate)
                <tr class="border-t border-gray-700">
                    <td class="py-2">{{ $candidate->name }}</td>
                    <td class="py-2">{{ $candidate->category?->name }}</td>
                    <td class="py-2 space-x-2">
                        <a href="{{ route('admin.candidates.edit', $candidate) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600" onclick="return confirm('Hapus kandidat?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $candidates->links() }}</div>
    </div>
</x-app-layout>


