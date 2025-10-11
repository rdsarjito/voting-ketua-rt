<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Manajemen User</h2>
    </x-slot>

    <div class="mb-4">
        <a href="{{ route('admin.users.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Tambah User</a>
    </div>
    
    @if(session('status'))
        <div class="p-3 bg-green-600 text-white rounded mb-4">{{ session('status') }}</div>
    @endif
    
    @if($errors->any())
        <div class="p-3 bg-red-600 text-white rounded mb-4">{{ $errors->first() }}</div>
    @endif

    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="py-2">Nama</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Role</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Total Vote</th>
                    <th class="py-2">Terakhir Login</th>
                    <th class="py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-t border-gray-700">
                    <td class="py-2">{{ $user->name }}</td>
                    <td class="py-2">{{ $user->email }}</td>
                    <td class="py-2">
                        <span class="px-2 py-1 {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }} rounded text-xs">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="py-2">
                        @if($user->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Aktif</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Diblokir</span>
                        @endif
                    </td>
                    <td class="py-2">{{ $user->votes_count }}</td>
                    <td class="py-2 text-sm">
                        {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Belum pernah' }}
                    </td>
                    <td class="py-2 space-x-2">
                        <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600">Detail</a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-green-600">Edit</a>
                        
                        <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-yellow-600" onclick="return confirm('Reset password user ini?')">Reset Password</button>
                        </form>
                        
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-orange-600" onclick="return confirm('{{ $user->is_active ? 'Blokir' : 'Buka blokir' }} user ini?')">
                                {{ $user->is_active ? 'Blokir' : 'Buka Blokir' }}
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600" onclick="return confirm('Hapus user ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</x-app-layout>
