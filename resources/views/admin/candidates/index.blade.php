<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kandidat</h2>
    </x-slot>

    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('admin.candidates.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah</a>
        <form method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kandidat..." class="border rounded p-2 bg-gray-100 dark:bg-gray-700" />
            <button class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cari</button>
        </form>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
        <table class="w-full text-left text-sm">
            <thead>
                <tr>
                    <th class="py-2">Nama</th>
                    <th class="py-2">Kategori</th>
                    <th class="py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($candidates as $candidate)
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="py-2">{{ $candidate->name }}</td>
                    <td class="py-2">{{ $candidate->category?->name }}</td>
                    <td class="py-2 space-x-2 text-right">
                        <a href="{{ route('admin.candidates.edit', $candidate) }}" class="px-2 py-1 rounded bg-blue-100 text-blue-700 hover:bg-blue-200">Edit</a>
                        <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="px-2 py-1 rounded bg-red-100 text-red-700 hover:bg-red-200" onclick="return confirm('Hapus kandidat?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $candidates->links() }}</div>
    </div>
</x-app-layout>


