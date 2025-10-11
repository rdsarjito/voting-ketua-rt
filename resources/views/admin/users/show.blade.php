<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Detail User: {{ $user->name }}</h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- User Info -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Informasi User</h3>
            <div class="space-y-2">
                <div><strong>Nama:</strong> {{ $user->name }}</div>
                <div><strong>Email:</strong> {{ $user->email }}</div>
                <div><strong>Role:</strong> 
                    <span class="px-2 py-1 {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }} rounded text-xs">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                <div><strong>Status:</strong> 
                    @if($user->is_active)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Aktif</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Diblokir</span>
                    @endif
                </div>
                <div><strong>Terdaftar:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</div>
                <div><strong>Terakhir Login:</strong> {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Belum pernah' }}</div>
            </div>
            
            <div class="mt-4 space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-2 bg-blue-600 text-white rounded text-sm">Edit</a>
                <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" class="inline">
                    @csrf
                    <button class="px-3 py-2 bg-yellow-600 text-white rounded text-sm" onclick="return confirm('Reset password user ini?')">Reset Password</button>
                </form>
                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                    @csrf
                    <button class="px-3 py-2 bg-orange-600 text-white rounded text-sm" onclick="return confirm('{{ $user->is_active ? 'Blokir' : 'Buka blokir' }} user ini?')">
                        {{ $user->is_active ? 'Blokir' : 'Buka Blokir' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Voting History -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Riwayat Voting ({{ $user->votes->count() }})</h3>
            @if($user->votes->count() > 0)
                <div class="space-y-3">
                    @foreach($user->votes as $vote)
                    <div class="border-l-4 border-blue-500 pl-3">
                        <div class="font-medium">{{ $vote->candidate->name }}</div>
                        <div class="text-sm text-gray-600">{{ $vote->candidate->category->name }}</div>
                        <div class="text-xs text-gray-500">{{ $vote->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Belum ada riwayat voting.</p>
            @endif
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.users.index') }}" class="px-3 py-2 bg-gray-600 text-white rounded">Kembali ke Daftar User</a>
    </div>
</x-app-layout>
