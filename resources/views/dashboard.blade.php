<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @auth
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Akses Panel Admin</h2>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Masuk ke panel utama untuk mengelola semua data aplikasi.
                        </p>
                        <div class="mt-6">
                            <a href="{{ url('/admin') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent
                                rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest
                                hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white
                                active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2
                                focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Masuk Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
{{--            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">--}}
{{--                <x-welcome />--}}
                <div class="flex items-center justify-center mb-6">
                    {{-- Ganti dengan logo Anda jika ada, atau gunakan ikon default --}}
{{--                    <img src="{{ asset('images/icon-logo-tsu.png') }}" alt="Logo Tiga Serangkai University">--}}
                    <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white">
                        Selamat Datang di TSU Homebase
                    </h1>
                </div>
{{--            </div>--}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <div class="p-6 bg-white dark:bg-gray-800 sm:rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Tentang Aplikasi</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        Aplikasi ini menyediakan fitur untuk manajemen user akses dan izin di sistem Tiga Serangkai University secara efisien dan terintegrasi.
                    </p>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800 sm:rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Status Sistem</h3>
                    <div class="mt-2 flex items-center">
                        <span class="h-3 w-3 rounded-full bg-green-500 mr-2"></span>
                        <p class="text-gray-500 dark:text-gray-400">
                            Semua sistem berjalan normal.
                        </p>
                    </div>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800 sm:rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Panduan Pengguna</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        Butuh bantuan? Silakan akses dokumentasi dan panduan lengkap penggunaan aplikasi melalui link yang tersedia di dalam panel admin.
                    </p>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800 sm:rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Hubungi Dukungan</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        Jika mengalami kendala teknis, silakan hubungi tim IT melalui email di <a href="mailto:support@tsu.ac.id" class="text-blue-500 hover:underline">support@tsu.ac.id</a>.
                    </p>
                </div>

            </div>

            <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} TSU Homebase. All Rights Reserved. Versi Aplikasi 1.0.0
            </div>
        </div>
    </div>
</x-app-layout>
