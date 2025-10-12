<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kirim Email</h2>
    </x-slot>

    @if(session('status'))
        <div class="p-3 bg-green-600 text-white rounded mb-4">{{ session('status') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Voting Reminder -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Kirim Reminder Voting</h3>
            <form method="POST" action="{{ route('admin.emails.reminder') }}">
                @csrf
                <div class="mb-4">
                    <label class="block mb-2">Pilih Kategori</label>
                    <select name="category_id" class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Pilih User (Ctrl+Click untuk multiple)</label>
                    <select name="user_ids[]" multiple class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700 h-32" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Kirim Reminder</button>
            </form>
        </div>

        <!-- Voting Results -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Kirim Hasil Voting</h3>
            <form method="POST" action="{{ route('admin.emails.results') }}">
                @csrf
                <div class="mb-4">
                    <label class="block mb-2">Pilih User (Ctrl+Click untuk multiple)</label>
                    <select name="user_ids[]" multiple class="w-full border rounded p-2 bg-gray-100 dark:bg-gray-700 h-32" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Kirim Hasil</button>
            </form>
        </div>
    </div>

    <div class="mt-6 bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Info Email</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <h4 class="font-semibold">Reminder Voting</h4>
                <p>Mengingatkan user untuk melakukan voting pada kategori tertentu.</p>
            </div>
            <div>
                <h4 class="font-semibold">Hasil Voting</h4>
                <p>Mengirim hasil lengkap voting ke user yang dipilih.</p>
            </div>
            <div>
                <h4 class="font-semibold">Konfirmasi Vote</h4>
                <p>Otomatis dikirim setelah user melakukan voting.</p>
            </div>
        </div>
    </div>
</x-app-layout>
