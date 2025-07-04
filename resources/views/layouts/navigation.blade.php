<div x-data="{ open: false }" class="fixed top-0 left-0 z-50">
    <!-- Sidebar for large screens (permanent) -->
    <div class="hidden lg:block w-64 h-screen bg-theme-surface shadow-lg overflow-y-auto lg:pl-[5%]">
        <div class="p-4">
            <!-- Logo -->
            <div class="flex items-center mb-6">
                <a href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('admin.dashboard') : route('kasir.dashboard')) : route('login') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-theme-primary" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="space-y-2">
                @if (Auth::check())
                @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    {{ __('Statistik Kas') }}
                </a>
                <a href="{{ route('admin.data-karyawan') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.data-karyawan') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    {{ __('Data Karyawan') }}
                </a>
                <a href="{{ route('admin.persediaan') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.persediaan') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18"></path>
                    </svg>
                    {{ __('Persediaan') }}
                </a>
                <a href="{{ route('admin.barang') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.barang') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z"></path>
                    </svg>
                    {{ __('Barang') }}
                </a>
                <a href="{{ route('admin.stock-opname') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.stock-opname') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    {{ __('Stock Opname') }}
                </a>
                <a href="{{ route('admin.saldo-bulanan') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.saldo-bulanan') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Saldo Bulanan') }}
                </a>
                <a href="{{ route('admin.gaji') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.gaji') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                    {{ __('Gaji Karyawan') }}
                </a>
                <a href="{{ route('admin.transaksi-shift') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.transaksi-shift') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('Transaksi Shift') }}
                </a>
                <a href="{{ route('admin.pengeluaran') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.pengeluaran') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"></path>
                    </svg>
                    {{ __('Pengeluaran') }}
                </a>
                <a href="{{ route('admin.transaksi-histori') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.transaksi-histori') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Histori Transaksi') }}
                </a>
                @elseif (Auth::user()->role === 'kasir')
                <a href="{{ route('kasir.dashboard') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('kasir.dashboard') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"></path>
                    </svg>
                    {{ __('Transaksi') }}
                </a>
                <a href="{{ route('kasir.persediaan') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('kasir.persediaan') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18"></path>
                    </svg>
                    {{ __('Persediaan') }}
                </a>
                @endif

                <!-- User Info and Logout -->
                <div class="border-t border-theme-primary mt-4 pt-4">
                    <div class="px-4 text-theme-black">{{ Auth::user()->nama }}</div>
                    <div class="px-4 text-sm text-theme-black">{{ Auth::user()->email }}</div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Navbar for small screens (full width) -->
    <div class="lg:hidden bg-theme-white border-b border-theme-primary shadow-sm fixed top-0 left-0 right-0 h-16 flex items-center px-4">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('admin.dashboard') : route('kasir.dashboard')) : route('login') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-theme-primary" />
            </a>
        </div>

        <!-- Hamburger (right-aligned) -->
        <div class="ml-auto">
            <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-theme-primary hover:text-theme-secondary hover:bg-theme-light focus:bg-theme-light focus:text-theme-primary focus:outline-none transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Drawer for small screens -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        class="lg:hidden fixed top-0 left-0 w-64 h-full bg-theme-surface shadow-lg z-50 overflow-y-auto" @click.away="open = false">
        <div class="p-4">
            <button @click="open = false" class="absolute top-4 right-4 text-theme-black hover:text-theme-secondary">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="mt-12 space-y-2">
                @if (Auth::check())
                @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    {{ __('Statistik Kas') }}
                </a>
                <a href="{{ route('admin.data-karyawan') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.data-karyawan') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    {{ __('Data Karyawan') }}
                </a>
                <a href="{{ route('admin.persediaan') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.persediaan') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18"></path>
                    </svg>
                    {{ __('Persediaan') }}
                </a>
                <a href="{{ route('admin.barang') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.barang') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z"></path>
                    </svg>
                    {{ __('Barang') }}
                </a>
                <a href="{{ route('admin.stock-opname') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.stock-opname') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    {{ __('Stock Opname') }}
                </a>
                <a href="{{ route('admin.saldo-bulanan') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.saldo-bulanan') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Saldo Bulanan') }}
                </a>
                <a href="{{ route('admin.gaji') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.gaji') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                    {{ __('Gaji Karyawan') }}
                </a>
                <a href="{{ route('admin.transaksi-shift') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.transaksi-shift') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('Transaksi Shift') }}
                </a>
                <a href="{{ route('admin.pengeluaran') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.pengeluaran') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"></path>
                    </svg>
                    {{ __('Pengeluaran') }}
                </a>
                <a href="{{ route('admin.transaksi-histori') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('admin.transaksi-histori') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Histori Transaksi') }}
                </a>
                @elseif (Auth::user()->role === 'kasir')
                <a href="{{ route('kasir.dashboard') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('kasir.dashboard') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"></path>
                    </svg>
                    {{ __('Transaksi') }}
                </a>
                <a href="{{ route('kasir.persediaan') }}"
                    class="flex items-center px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150 {{ request()->routeIs('kasir.persediaan') ? 'bg-theme-light' : '' }} border-b border-gray-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18"></path>
                    </svg>
                    {{ __('Persediaan') }}
                </a>
                @endif

                <!-- User Info and Logout -->
                <div class="border-t border-theme-primary mt-4 pt-4">
                    <div class="px-4 text-theme-black">{{ Auth::user()->nama }}</div>
                    <div class="px-4 text-sm text-theme-black">{{ Auth::user()->email }}</div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-2 text-theme-black hover:bg-theme-light hover:text-theme-secondary focus:bg-theme-light focus:text-theme-primary transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Overlay for small screens -->
    <div x-show="open" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-75"
        x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-75" x-transition:leave-end="opacity-0"
        class="lg:hidden fixed inset-0 bg-black bg-opacity-75 z-40" @click="open = false"></div>
</div>

<style>
    body {
        transition: padding-left 0.3s ease;
    }

    @media (max-width: 1023px) {
        body {
            padding-top: 4rem;
        }
    }

    @media (min-width: 1024px) {
        body {
            padding-left: 16rem;
        }
    }

    .swal-custom-buttons button {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        margin-right: 0.5rem;
    }
</style>