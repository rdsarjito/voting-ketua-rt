<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-950 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 opacity-70"></div>
        <div class="absolute -top-32 -right-40 w-96 h-96 bg-blue-400/30 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 left-0 w-1/2 h-1/2 bg-cyan-400/20 blur-3xl rounded-full"></div>

        <div class="relative max-w-5xl w-full px-6 lg:px-10">
            <div class="grid lg:grid-cols-5 gap-8 bg-white/10 backdrop-blur-2xl rounded-[32px] border border-white/20 shadow-2xl shadow-blue-900/40 overflow-hidden">
                <div class="lg:col-span-3 p-8 lg:p-12 text-white">
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center shadow-inner shadow-black/20">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.5em] text-white/70">Voting</p>
                            <h1 class="text-3xl font-semibold leading-tight">Ketua RT Online</h1>
                        </div>
                    </div>

                    <div class="mt-10 space-y-6">
                        <p class="text-lg text-white/80 leading-relaxed max-w-xl">
                            Pengalaman pemilihan yang imersif dengan transparansi real-time, notifikasi langsung, dan keamanan berlapis.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <div class="px-4 py-2 rounded-full bg-white/10 text-sm font-medium tracking-wide text-white/80 border border-white/20">
                                Realtime Monitoring
                            </div>
                            <div class="px-4 py-2 rounded-full bg-white/10 text-sm font-medium tracking-wide text-white/80 border border-white/20">
                                Notifikasi Otomatis
                            </div>
                            <div class="px-4 py-2 rounded-full bg-white/10 text-sm font-medium tracking-wide text-white/80 border border-white/20">
                                Audit Log Lengkap
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-6">
                            <div class="rounded-2xl border border-white/20 bg-white/5 p-5">
                                <p class="text-sm uppercase tracking-[0.3em] text-white/60 mb-2">Pemilih aktif</p>
                                <p class="text-3xl font-bold">1.204</p>
                                <p class="text-sm text-white/70 mt-1">Dengan tingkat partisipasi 92%</p>
                            </div>
                            <div class="rounded-2xl border border-white/20 bg-white/5 p-5">
                                <p class="text-sm uppercase tracking-[0.3em] text-white/60 mb-2">Audit sukses</p>
                                <p class="text-3xl font-bold">100%</p>
                                <p class="text-sm text-white/70 mt-1">Tanpa anomali tercatat</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex items-center gap-4 text-sm text-white/70">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-white/30 object-cover" src="https://images.unsplash.com/photo-1520340356584-8f4a478ba6eb?auto=format&fit=facearea&w=128&h=128&q=60" alt="avatar">
                            <img class="w-10 h-10 rounded-full border-2 border-white/30 object-cover" src="https://images.unsplash.com/photo-1504593811423-6dd665756598?auto=format&fit=facearea&w=128&h=128&q=60" alt="avatar">
                            <img class="w-10 h-10 rounded-full border-2 border-white/30 object-cover" src="https://images.unsplash.com/photo-1502767089025-6572583495b0?auto=format&fit=facearea&w=128&h=128&q=60" alt="avatar">
                        </div>
                        <div>
                            Dipercaya warga RW 08 • <span class="font-semibold text-white">4.9/5</span> rating pengalaman
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-[28px] lg:rounded-l-[40px] lg:rounded-r-none p-8 shadow-xl">
                    <div class="mb-8">
                        <p class="text-xs uppercase tracking-[0.35em] text-blue-600 dark:text-blue-400 mb-2">Masuk</p>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white leading-tight">Mulai Kelola Pemilihan</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Gunakan akun Anda untuk mengakses dashboard.</p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                class="w-full px-4 py-3 border border-slate-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition @error('email') border-red-500 focus:ring-red-500 @enderror"
                                placeholder="nama@email.com"
                            >
                            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Password</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                class="w-full px-4 py-3 border border-slate-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition @error('password') border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan password"
                            >
                            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                        </div>

                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                                <input id="remember_me" type="checkbox" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer" name="remember">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:opacity-90 text-white font-semibold rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-600/30 transition">
                            Masuk ke Dashboard
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            Daftar sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>