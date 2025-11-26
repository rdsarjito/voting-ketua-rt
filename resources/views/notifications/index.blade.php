<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pusat Notifikasi</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Pantau aktivitas voting terbaru, perubahan periode, dan tindakan admin secara real-time.
                </p>
            </div>

            <form method="POST" action="{{ route('notifications.read-all') }}" class="flex gap-3">
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center rounded-lg border border-transparent bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    @if($unreadCount === 0) disabled @endif
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="ml-2">Tandai Semua Dibaca</span>
                </button>
            </form>
        </div>

        <div class="rounded-2xl border border-dashed border-gray-200 bg-white/40 p-4 dark:border-gray-700 dark:bg-gray-800/40">
            <form method="GET" class="grid gap-3 sm:grid-cols-3 sm:items-end">
                <div>
                    <label for="type" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        Jenis Notifikasi
                    </label>
                    <select
                        id="type"
                        name="type"
                        class="mt-1 w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                    >
                        <option value="all" @selected($filterType === 'all')>Semua</option>
                        @foreach($availableTypes as $type)
                            <option value="{{ $type }}" @selected($filterType === $type)>{{ \Illuminate\Support\Str::headline($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        Status
                    </label>
                    <select
                        id="status"
                        name="status"
                        class="mt-1 w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                    >
                        <option value="all" @selected($filterStatus === 'all')>Semua</option>
                        <option value="unread" @selected($filterStatus === 'unread')>Belum Dibaca</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button
                        type="submit"
                        class="inline-flex flex-1 items-center justify-center rounded-lg border border-indigo-600 bg-white px-4 py-2 text-sm font-semibold text-indigo-700 shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-indigo-500 dark:bg-transparent dark:text-indigo-200 dark:hover:bg-indigo-500/10"
                    >
                        Terapkan
                    </button>

                    @if($filterType !== 'all' || $filterStatus !== 'all')
                        <a
                            href="{{ route('notifications.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                        >
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="grid gap-4">
            @forelse ($notifications as $notification)
                @php
                    $isUnread = is_null($notification->read_at);
                    $typeColors = [
                        'vote_cast' => 'border-emerald-500/70 bg-emerald-50 dark:bg-emerald-500/10',
                        'admin_action' => 'border-amber-500/70 bg-amber-50 dark:bg-amber-500/10',
                        'voting_period' => 'border-sky-500/70 bg-sky-50 dark:bg-sky-500/10',
                        'default' => 'border-gray-400/70 bg-white dark:bg-gray-800',
                    ];
                    $colorClass = $typeColors[$notification->type] ?? $typeColors['default'];
                @endphp
                <div class="rounded-2xl border-l-4 {{ $colorClass }} p-5 shadow-sm ring-1 ring-black/5 dark:ring-white/5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="flex items-center gap-3">
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $notification->title }}
                                </p>
                                @if($isUnread)
                                    <span class="inline-flex items-center rounded-full bg-indigo-600/10 px-3 py-1 text-xs font-medium text-indigo-700 dark:text-indigo-300">
                                        Baru
                                    </span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                {{ $notification->message }}
                            </p>
                            <div class="mt-3 flex flex-wrap items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                        <circle cx="12" cy="12" r="9" />
                                    </svg>
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                @if($notification->data && isset($notification->data['category']))
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                                        </svg>
                                        {{ $notification->data['category'] }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            @if($notification->data && isset($notification->data['url']))
                                <a
                                    href="{{ $notification->data['url'] }}"
                                    class="inline-flex items-center rounded-lg border border-transparent bg-white/60 px-3 py-2 text-xs font-medium text-gray-700 shadow-sm ring-1 ring-gray-900/5 transition hover:bg-white dark:bg-white/10 dark:text-gray-100"
                                >
                                    Lihat Detail
                                </a>
                            @endif
                            @if($isUnread)
                                <form method="POST" action="{{ route('notifications.mark-as-read', $notification) }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="inline-flex items-center rounded-lg border border-transparent bg-indigo-600 px-3 py-2 text-xs font-semibold text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    >
                                        Tandai Dibaca
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-200/70 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-700/70 dark:text-gray-300">
                                    Sudah dibaca {{ $notification->read_at?->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-gray-300 bg-white/60 p-10 text-center shadow-sm dark:border-gray-600 dark:bg-gray-800/50">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50 text-indigo-500 dark:bg-indigo-500/10">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Semua aman 🎉</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada notifikasi baru untukmu saat ini.</p>
                </div>
            @endforelse
        </div>

        <div>
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>

