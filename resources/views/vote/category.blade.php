<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $category->name }}</h2>
    </x-slot>

    @if(session('status'))
        <div class="p-3 bg-green-600 text-white rounded mb-4">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="p-3 bg-red-600 text-white rounded mb-4">{{ $errors->first() }}</div>
    @endif

    @if($existingVote)
        <div class="p-3 bg-yellow-600 text-white rounded mb-4">Anda sudah memilih kandidat di kategori ini.</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($category->candidates as $candidate)
        <div class="relative p-6 bg-gradient-to-br from-white to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl border border-gray-200/80 dark:border-gray-700/60 transition transform hover:-translate-y-0.5">
            <div class="absolute inset-x-0 top-0 h-2 rounded-t-2xl bg-gradient-to-r from-white/70 via-white/30 to-white/70 dark:from-white/10 dark:via-white/5 dark:to-white/10"></div>
            <div class="flex items-start gap-4">
            @if($candidate->photo)
                <img src="{{ asset('storage/'.$candidate->photo) }}" class="h-24 w-24 object-cover rounded-2xl shadow-inner border border-white/60 dark:border-white/10" />
            @endif
                <div class="flex-1">
                    <div class="text-xl font-semibold tracking-tight text-gray-900 dark:text-gray-100">{{ $candidate->name }}</div>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 shadow-inner dark:bg-amber-500/15 dark:text-amber-200 dark:border-amber-400/20">{{ $category->name }}</span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-sky-50 text-sky-700 border border-sky-200 shadow-inner dark:bg-sky-500/15 dark:text-sky-200 dark:border-sky-400/20">Kandidat</span>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class="font-semibold">Visi</div>
                <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">{{ $candidate->vision }}</div>
            </div>
            <div class="mt-2">
                <div class="font-semibold">Misi</div>
                <div class="text-sm text-gray-700 dark:text-gray-300 leading-6">{{ $candidate->mission }}</div>
            </div>

            @if(!$existingVote && $category->isVotingOpen())
            <form method="POST" action="{{ route('vote.store', $candidate) }}" class="mt-4">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->id }}" />
                <button class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow active:scale-[0.99] transition" onclick="return confirm('Pilih {{ $candidate->name }}?')">Pilih Kandidat</button>
            </form>
            @elseif(!$category->isVotingOpen())
                <div class="mt-4 p-2 bg-yellow-100 text-yellow-800 rounded-xl text-sm border border-yellow-200 shadow-inner">
                    Voting belum dibuka atau sudah ditutup
                </div>
            @endif
        </div>
        @endforeach
    </div>
</x-app-layout>


