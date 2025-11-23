<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        {{-- Card besar 2 kolom --}}
        <div class="w-full max-w-4xl bg-white/80 backdrop-blur-xl shadow-xl rounded-3xl border border-white/60 overflow-hidden">

            <div class="grid md:grid-cols-2">
                {{-- Panel kiri: branding / info --}}
                <div class="hidden md:flex flex-col justify-between p-8 bg-gradient-to-br from-indigo-500 via-indigo-600 to-purple-500 text-white">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight mb-2">
                            LearnHub
                        </h1>
                        <p class="text-sm text-indigo-100">
                            Platform belajar untuk mengembangkan skillmu, kapan saja dan di mana saja.
                        </p>
                    </div>

                    <div class="mt-8 space-y-3 text-sm text-indigo-100">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-xs">
                                1
                            </span>
                            <p>Akses course yang kamu ikuti dengan mudah.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-xs">
                                2
                            </span>
                            <p>Pantau progres belajarmu secara real-time.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-xs">
                                3
                            </span>
                            <p>Dapatkan sertifikat setelah menyelesaikan kursus.</p>
                        </div>
                    </div>

                    <p class="mt-8 text-[11px] text-indigo-100/80">
                        © {{ date('Y') }} LearnHub. All rights reserved.
                    </p>
                </div>

                {{-- Panel kanan: form login --}}
                <div class="p-8">
                    <!-- Header -->
                    <div class="text-center mb-6">
                        {{-- kalau mau pakai logo, aktifkan img di bawah --}}
                        {{-- <img src="/logo/logo.jpeg" class="mx-auto h-14 mb-3 rounded-lg shadow-sm" alt="Logo"> --}}
                        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang <img src="public/logo/logo.jpeg"></h2>
                        <p class="text-gray-500 text-sm">
                            Silakan login untuk melanjutkan ke dashboard kamu.
                        </p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email"
                                class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                type="email" name="email"
                                :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                            @if (session('error'))
    <div class="mb-4 text-sm text-red-600">
        {{ session('error') }}
    </div>
@endif

                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password"
                                class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between mt-2">
                            <label for="remember_me" class="flex items-center gap-2">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    name="remember">
                                <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-600 hover:text-indigo-800"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                            
                        </div>

                        <!-- Button -->
                        <div>
                            <x-primary-button
                                class="w-full justify-center py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 transition shadow-sm hover:shadow-md">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Footer kecil untuk mobile -->
                    <p class="text-center text-[11px] text-gray-400 mt-6 md:hidden">
                        © {{ date('Y') }} LearnHub. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
