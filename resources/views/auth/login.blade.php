<x-guest-layout>
    <div class="relative flex h-screen items-center justify-center overflow-hidden">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-theme-primary bg-opacity-30 z-10"></div>

        <!-- Form Container -->
        <div class="relative z-20 w-full max-w-md p-6 bg-theme-surface border border-theme-primary rounded-lg shadow-md">
            <div class="flex justify-center mb-6">
                <x-application-logo class="h-12 w-auto fill-current text-theme-black" />
            </div>

            <h2 class="text-2xl font-bold text-center mb-6 text-theme-black">Selamat Datang</h2>

            @if (session('status'))
                <div class="mb-4 text-sm text-theme-primary">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-theme-black">Email</label>
                    <div class="relative">
                        <input id="email" type="email" name="email" required autofocus
                            placeholder="Masukkan email"
                            class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10"
                            autocomplete="username">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </span>
                    </div>
                    @error('email')
                        <span class="text-red-600 text-sm error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-theme-black">Password</label>
                    <div class="relative" x-data="{ showPassword: false }" x-cloak>
                        <input id="password" x-bind:type="showPassword ? 'text' : 'password'" name="password" required
                            placeholder="Masukkan password"
                            class="mt-1 block w-full rounded-md border-theme-black shadow-sm focus:border-theme-primary focus:ring-theme-secondary pl-10 pr-10"
                            autocomplete="off">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-theme-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" x-on:click="showPassword = !showPassword">
                            <svg x-show="!showPassword" class="h-5 w-5 text-theme-primary" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M10 3C5.5 3 1.6 6.1 0 10c1.6 3.9 5.5 7 10 7s8.4-3.1 10-7c-1.6-3.9-5.5-7-10-7zm0 12a5 5 0 01-5-5 5 5 0 0110 0 5 5 0 01-5 5z" clip-rule="evenodd" />
                            </svg>
                            <svg x-show="showPassword" class="h-5 w-5 text-theme-primary" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                            </svg>
                        </span>
                    </div>
                    @error('password')
                        <span class="text-red-600 text-sm error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-theme-primary text-theme-white rounded-md hover:bg-theme-secondary focus:outline-none focus:ring-2 focus:ring-theme-secondary">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add x-cloak CSS to hide elements until Alpine.js is loaded -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- SweetAlert2 for Success and Errors -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "Login berhasil! Selamat datang!",
                    confirmButtonText: 'OK'
                });
            });
    </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: '{{ $errors->first() }}',
                    confirmButtonText: 'OK',
                });
            });
        </script>
    @endif
</x-guest-layout>