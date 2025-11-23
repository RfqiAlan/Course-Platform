<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-4xl w-full bg-white/80 backdrop-blur shadow-xl rounded-3xl overflow-hidden border border-indigo-50">
            <div class="grid md:grid-cols-2">
                {{-- Kolom kiri: branding / deskripsi --}}
                <div class="hidden md:flex flex-col justify-between bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-500 text-white p-8">
                    <div>
                        <h1 class="text-2xl font-semibold mb-2">
                            Selamat datang di {{ config('app.name', 'LearnHub') }}
                        </h1>
                        <p class="text-sm text-indigo-100">
                            Daftar dan mulai perjalanan belajarmu. Akses course, ikuti diskusi,
                            dan pantau progres belajar dalam satu platform.
                        </p>
                    </div>

                    <div class="mt-8 space-y-3 text-sm text-indigo-100">
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/10 text-xs">
                                1
                            </span>
                            <p>Buat akun dengan email aktif dan password yang aman.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/10 text-xs">
                                2
                            </span>
                            <p>Enroll course yang kamu minati dan mulai belajar.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/10 text-xs">
                                3
                            </span>
                            <p>Raih sertifikat setelah menyelesaikan course tertentu.</p>
                        </div>
                    </div>

                    <div class="mt-8 text-xs text-indigo-100/80">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold underline underline-offset-2">
                            Masuk di sini
                        </a>
                    </div>
                </div>

                {{-- Kolom kanan: form register --}}
                <div class="p-6 sm:p-8">
                    <div class="mb-6 text-center md:text-left">
                        <h2 class="text-xl font-semibold text-gray-900">
                            Buat Akun Baru
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Isi data di bawah ini untuk mulai menggunakan {{ config('app.name', 'LearnHub') }}.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name"
                                class="block mt-1 w-full"
                                type="text"
                                name="name"
                                :value="old('name')"
                                required
                                autofocus
                                autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email"
                                class="block mt-1 w-full"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="flex items-center justify-between">
                                <x-input-label for="password" :value="__('Password')" />
                                <span class="text-xs text-gray-400">
                                    Min. 8 karakter
                                </span>
                            </div>

                            <x-text-input id="password"
                                class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation"
                                class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        {{-- Checkbox syarat & ketentuan (opsional) --}}
                        <div class="pt-1">
                            <label class="inline-flex items-start gap-2 text-xs text-gray-500">
                                <input type="checkbox"
                                    class="mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    required>
                                <span>
                                    Saya menyetujui syarat dan ketentuan penggunaan platform ini.
                                </span>
                            </label>
                        </div>

                        <div class="pt-3 flex flex-col gap-3">
                            <x-primary-button class="w-full justify-center">
                                {{ __('Daftar Sekarang') }}
                            </x-primary-button>

                            <p class="text-xs text-gray-500 text-center">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
