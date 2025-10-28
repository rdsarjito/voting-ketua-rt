<x-guest-layout>
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <!-- Left: Branding / Illustration -->
        <div class="hidden lg:flex flex-col justify-between bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-500 text-white p-12">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-lg font-semibold tracking-wide">Voting Ketua RT</div>
            </div>

            <div>
                <h1 class="text-4xl font-bold leading-tight">Selamat Datang di Sistem Voting Online</h1>
                <p class="mt-4 text-white/90 max-w-lg">Pilih kandidat terbaik Anda secara mudah, cepat, dan aman. Pantau hasil secara real-time dan dapatkan notifikasi otomatis.</p>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-xl">
                    <div class="bg-white/10 rounded-xl p-4 backdrop-blur">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-white/20 flex items-center justify-center">
                                <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 5a2 2 0 012-2h3.5a1 1 0 01.8.4l1.9 2.4H16a2 2 0 012 2v1H2V5z" /><path d="M2 9h16v4a2 2 0 01-2 2H4a2 2 0 01-2-2V9z" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold">UI Modern</div>
                                <div class="text-sm text-white/80">Desain bersih dan responsif</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4 backdrop-blur">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-white/20 flex items-center justify-center">
                                <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold">Real-time</div>
                                <div class="text-sm text-white/80">Notifikasi dan hasil langsung</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4 backdrop-blur">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-white/20 flex items-center justify-center">
                                <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9l7.997-3.116A2 2 0 0016.26 3H3.74a2 2 0 00-1.737 2.884z" /><path d="M18 8.118l-8 3.118-8-3.118V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold">Email</div>
                                <div class="text-sm text-white/80">Pengingat & konfirmasi</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4 backdrop-blur">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-white/20 flex items-center justify-center">
                                <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v6a2 2 0 002 2h2l2 2 2-2h4a2 2 0 002-2V9a1 1 0 10-2 0v3H4V6a2 2 0 012-2h7a1 1 0 100-2H6a2 2 0 00-2 2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold">Audit Log</div>
                                <div class="text-sm text-white/80">Jejak aktivitas aman</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-sm text-white/80">© {{ date('Y') }} Voting Ketua RT</div>
        </div>

        <!-- Right: Login Form -->
        <div class="flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full">
                <div class="bg-white dark:bg-gray-800 py-8 px-6 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <div class="mx-auto h-14 w-14 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">Masuk</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Gunakan akun Anda untuk melanjutkan</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6 mt-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition duration-200 @error('email') border-red-500 @enderror" placeholder="Masukkan email Anda">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" required autocomplete="current-password" class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition duration-200 @error('password') border-red-500 @enderror" placeholder="Masukkan password Anda">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center gap-2">
                                <input id="remember_me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" name="remember">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition" href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="w-full py-3 px-4 text-sm font-medium rounded-xl text-white bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-lg">Masuk</button>

                        <!-- Register -->
                        <p class="text-center text-sm text-gray-600 dark:text-gray-400">Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Daftar sekarang</a></p>
                    </form>
                </div>
                <p class="mt-6 text-center text-xs text-gray-500 dark:text-gray-400">© {{ date('Y') }} Sistem Voting Online</p>
            </div>
        </div>
    </div>
</x-guest-layout>