<x-guest-layout>
    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 flex">
        <!-- Corporate Panel -->
        <div class="hidden lg:flex w-1/2 flex-col justify-between bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 px-12 py-16">
            <div>
                <div class="inline-flex items-center gap-3 mb-10">
                    <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.5em] text-slate-400">Voting</p>
                        <h1 class="text-3xl font-semibold text-slate-900 dark:text-white">Ketua RT Online</h1>
                    </div>
                </div>
                <p class="text-lg text-slate-600 dark:text-slate-300 leading-relaxed max-w-md">
                    Platform pemilihan modern dengan fokus pada transparansi, keamanan, dan pengalaman pengguna yang profesional.
                </p>
                <div class="mt-12 space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900 dark:text-white text-sm">Pengawasan Real-time</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Monitoring suara langsung dengan dashboard admin.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900 dark:text-white text-sm">Notifikasi Otomatis</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Email, reminder, dan notifikasi pusher setiap ada aksi penting.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M17 7h.01M7 11h.01M17 11h.01M7 15h.01M17 15h.01" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900 dark:text-white text-sm">Audit & Keamanan</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Log aktivitas lengkap serta pembatasan akses berbasis peran.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-xs text-slate-400">© {{ date('Y') }} Voting Ketua RT</div>
        </div>

        <!-- Form Panel -->
        <div class="flex-1 flex items-center justify-center px-6 lg:px-12 py-12">
            <div class="w-full max-w-md">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 p-8">
                    <div class="mb-8">
                        <p class="text-xs uppercase tracking-[0.35em] text-blue-600 dark:text-blue-400 mb-2">Masuk</p>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Selamat Datang Kembali</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Masukkan kredensial Anda untuk melanjutkan.</p>
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
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition @error('email') border-red-500 focus:ring-red-500 @enderror"
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
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition @error('password') border-red-500 focus:ring-red-500 @enderror"
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

                        <button type="submit" class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg transition">
                            Masuk
                        </button>
                    </form>
                </div>

                <p class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>