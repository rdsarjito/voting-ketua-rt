<aside class="w-64 bg-white dark:bg-gray-800 min-h-screen p-4 hidden md:block">
    <nav class="space-y-2">
        <a href="{{ route('dashboard') }}"
           class="block {{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold' : 'text-gray-700 dark:text-gray-200' }}">
            Dashboard
        </a>
        <a href="{{ route('vote.categories') }}"
           class="block {{ request()->routeIs('vote.categories') ? 'text-blue-600 font-semibold' : 'text-gray-700 dark:text-gray-200' }}">
            Kategori Voting
        </a>

        @auth
            @if(auth()->user()->role === 'admin')
                <hr class="my-2 border-gray-600" />
                <a href="{{ route('admin.categories.index') }}"
                   class="block {{ request()->routeIs('admin.categories.*') ? 'text-blue-600 font-semibold' : 'text-gray-700 dark:text-gray-200' }}">
                    Kelola Kategori
                </a>
                <a href="{{ route('admin.candidates.index') }}"
                   class="block {{ request()->routeIs('admin.candidates.*') ? 'text-blue-600 font-semibold' : 'text-gray-700 dark:text-gray-200' }}">
                    Kelola Kandidat
                </a>
                <a href="{{ route('admin.results') }}"
                   class="block {{ request()->routeIs('admin.results') ? 'text-blue-600 font-semibold' : 'text-gray-700 dark:text-gray-200' }}">
                    Hasil Voting
                </a>
            @endif
        @endauth
    </nav>
</aside>


