<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Kandidat</h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow max-w-2xl">
        <form method="POST" action="{{ route('admin.candidates.update', $candidate) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $candidate->name) }}" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700" />
                @error('name')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1">Foto</label>
                <input type="file" name="photo" class="w-full" />
                @if($candidate->photo)
                    <img src="{{ asset('storage/'.$candidate->photo) }}" class="h-24 mt-2" />
                @endif
                @error('photo')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1">Visi</label>
                <textarea name="vision" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700">{{ old('vision', $candidate->vision) }}</textarea>
                @error('vision')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1">Misi</label>
                <textarea name="mission" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700">{{ old('mission', $candidate->mission) }}</textarea>
                @error('mission')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1">Kategori</label>
                <select name="category_id" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700">
                    @foreach($categories as $id => $name)
                        <option value="{{ $id }}" @selected(old('category_id', $candidate->category_id)==$id)>{{ $name }}</option>
                    @endforeach
                </select>
                @error('category_id')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <button class="px-3 py-2 bg-blue-600 text-white rounded">Simpan</button>
                <a href="{{ route('admin.candidates.index') }}" class="px-3 py-2">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>


