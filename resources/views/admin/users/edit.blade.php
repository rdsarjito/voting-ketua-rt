<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit User</h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow max-w-2xl">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700" />
                @error('name')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700" />
                @error('email')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label class="block mb-1">Password (kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700" />
                @error('password')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label class="block mb-1">Role</label>
                <select name="role" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700">
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="mr-2" />
                    Aktif
                </label>
                @error('is_active')<div class="text-red-500 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div>
                <button class="px-3 py-2 bg-blue-600 text-white rounded">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="px-3 py-2">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
