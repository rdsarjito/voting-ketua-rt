<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Kategori</h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow max-w-2xl">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700" />
                @error('name')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label class="block mb-1">Tanggal Mulai Voting</label>
                <input type="datetime-local" name="voting_start" value="{{ old('voting_start', $category->voting_start?->format('Y-m-d\TH:i')) }}" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700" />
                @error('voting_start')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label class="block mb-1">Tanggal Berakhir Voting</label>
                <input type="datetime-local" name="voting_end" value="{{ old('voting_end', $category->voting_end?->format('Y-m-d\TH:i')) }}" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700" />
                @error('voting_end')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="mr-2" />
                    Aktif
                </label>
                @error('is_active')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div>
                <button class="px-3 py-2 bg-blue-600 text-white rounded">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="px-3 py-2">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>


