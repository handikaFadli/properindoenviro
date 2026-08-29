<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="auth-user-id" content="{{ auth()->id() }}">

    <title>@yield('title', config('app.name', 'Admin'))</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('logo/logo-identas-white.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />

    {{-- Vite: Tailwind CSS + Flowbite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-gray-900 antialiased">

    <div
    id="loading-screen"
    class="hidden fixed inset-0 z-[9999] bg-white/80 backdrop-blur-lg items-center justify-center">

        <div class="flex flex-col items-center gap-3">
            <div class="loading">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

    </div>

    @include('layouts.partials.navbar-dashboard')

    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

        @include('layouts.partials.sidebar')

        <div id="main-content"
             class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">

            <main class="p-4 w-full">
                {{-- Flash message sukses --}}
                @if (session('success'))
                <div id="toast-notif"
                    class="fixed top-5 right-5 z-50 flex items-center w-full max-w-sm p-4 text-gray-700 bg-white rounded-lg shadow-lg border border-gray-200 animate-toast-in"
                    role="alert">
                    <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-600 bg-green-100 rounded-full">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
                        </svg>
                    </div>
                    <div class="ms-3 text-sm font-medium">
                        <p class="font-semibold text-gray-900">Berhasil!</p>
                        <p class="text-gray-600">{{ session('success') }}</p>
                    </div>
                   
                </div>
                @endif

                {{-- Flash message error --}}
                    @if (session('error'))

                        <div
                            id="toast-notif"
                            class="fixed top-5 right-5 z-50 flex items-center w-full max-w-sm p-4
                                text-gray-700 bg-white rounded-lg shadow-lg
                                border border-gray-200 animate-toast-in"
                            role="alert"
                        >

                            {{-- Icon --}}
                            <div
                                class="inline-flex items-center justify-center shrink-0
                                    w-8 h-8 text-red-600 bg-red-100 rounded-full"
                            >

                                <svg
                                    class="w-5 h-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"
                                    />
                                </svg>

                            </div>

                            {{-- Message --}}
                            <div class="ms-3 text-sm font-medium">

                                <p class="font-semibold text-gray-900">
                                    Gagal!
                                </p>

                                <p class="text-gray-600">
                                    {{ session('error') }}
                                </p>

                            </div>

                        </div>

                    @endif

                {{-- Konten halaman di-inject di sini --}}
                @yield('content')
            </main>

            {{-- @include('layouts.partials.footer-dashboard') --}}

        </div>
        
        <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
            <div id="delete-modal-content" class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 p-6 scale-95 opacity-0 transition-all duration-200">
                <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 rounded-full bg-red-100 text-red-600">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3Z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 text-center">Yakin ingin menghapus?</h3>
                <p id="delete-modal-desc" class="text-sm text-gray-500 text-center mt-1">Data ini akan dihapus secara permanen.</p>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="button" onclick="confirmDelete()"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors cursor-pointer">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>

    </div>

    {{-- Script tambahan per halaman --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script> --}}

    <script>
    // Auto dismiss setelah 4 detik
        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('toast-notif');
            if (toast) {
                setTimeout(() => {
                    toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }, 4000);
            }
        });
    </script>

    <script>
        let formToDelete = null;

        function openDeleteModal(formId, itemName = null) {
            formToDelete = document.getElementById(formId);
            const modal = document.getElementById('delete-modal');
            const content = document.getElementById('delete-modal-content');
            const desc = document.getElementById('delete-modal-desc');

            if (itemName) {
                desc.textContent = `Data "${itemName}" akan dihapus secara permanen.`;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            requestAnimationFrame(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            });
        }

        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');
            const content = document.getElementById('delete-modal-content');

            content.classList.add('scale-95', 'opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                formToDelete = null;
            }, 150);
        }

        function confirmDelete() {
            if (formToDelete) {
                formToDelete.submit();
            }
        }

        // Close modal kalau klik area luar (backdrop)
        document.getElementById('delete-modal').addEventListener('click', function (e) {
            if (e.target === this) closeDeleteModal();
        });

        // Close modal dengan tombol Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>
    @stack('scripts')

</body>
</html>
