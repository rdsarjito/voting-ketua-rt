<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Kategori</h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow max-w-xl">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700" />
                @error('name')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <button class="px-3 py-2 bg-blue-600 text-white rounded">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="px-3 py-2">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>


