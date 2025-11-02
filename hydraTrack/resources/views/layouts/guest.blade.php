<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- START: AESTHETIC & DARK MODE OVERRIDES -->
        <style>
            /* Shared variables from index.blade.php */
            :root {
                --bg-color: #f7f3ed; /* Light Beige Background */
                --container-bg: #ffffff;
                --text-color: #3f3f3f; /* Dark Taupe Text */
                --primary-color: #a38c82; /* Dusty Rose/Taupe Accent */
                --secondary-color: #8c8c8c;
                --input-border: #d4d0c7;
                --shadow-color: rgba(0, 0, 0, 0.08);
            }

            body.dark-mode {
                --bg-color: #2e2825; 
                --container-bg: #3c3532;
                --text-color: #e3dcd7; 
                --primary-color: #c9b1a7; 
                --secondary-color: #bfa79f;
                --input-border: #5a514d;
                --shadow-color: rgba(255, 255, 255, 0.05);
            }
            
            /* GLOBAL OVERRIDES */
            .font-sans, .text-gray-900, .dark\:text-gray-100, label {
                font-family: 'Georgia', serif !important;
                color: var(--text-color) !important;
            }

            /* BACKGROUND (bg-gray-100) */
            .min-h-screen {
                background-color: var(--bg-color) !important;
                transition: background-color 0.4s;
            }
            
            /* CARD LOGIN/REGISTER (bg-white) */
            .bg-white, .dark\:bg-gray-900 {
                background-color: var(--container-bg) !important;
                box-shadow: 0 8px 20px var(--shadow-color) !important;
                border-radius: 16px !important;
                transition: background-color 0.4s;
            }
            
            /* INPUT FIELDS */
            input[type="email"], input[type="password"], input[type="text"] {
                border-color: var(--input-border) !important;
                background-color: var(--container-bg) !important;
                color: var(--text-color) !important;
                border-radius: 8px !important;
            }
            input[type="email"]:focus, input[type="password"]:focus, input[type="text"]:focus {
                border-color: var(--primary-color) !important;
                box-shadow: 0 0 0 2px var(--primary-color) !important;
            }
            
            /* PRIMARY BUTTON (bg-gray-800) */
            .bg-gray-800, .hover\:bg-gray-700 {
                background-color: var(--primary-color) !important;
                border-radius: 8px !important;
                transition: background-color 0.3s;
                font-family: 'Georgia', serif;
                font-weight: bold;
            }
            .bg-gray-800:hover, .hover\:bg-gray-700:hover {
                background-color: var(--secondary-color) !important;
            }
            
            /* LOGO */
            .fill-current {
                fill: var(--primary-color) !important;
            }
            
            /* LINKS (forgot password, already registered) */
            .underline {
                color: var(--primary-color) !important;
                text-decoration-color: var(--primary-color) !important;
            }
            .underline:hover {
                color: var(--secondary-color) !important;
            }
        </style>
        <!-- END: AESTHETIC & DARK MODE OVERRIDES -->
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <!-- Anda bisa mengganti logo Laravel dengan branding HydraTracker -->
                    <h1 style="font-size: 2.5em; color: var(--primary-color); font-weight: 300; font-family: Georgia, serif;">HydraTracker</h1>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        <!-- START: DARK MODE PERSISTENCE SCRIPT -->
        <script>
            // Logika Dark Mode Persistensi (Harus ada di layout)
            const body = document.body;
            const storageKey = 'hydraTrackerDarkMode';

            // Cek status terakhir saat halaman dimuat
            const savedMode = localStorage.getItem(storageKey);
            if (savedMode === 'dark') {
                body.classList.add('dark-mode'); 
            }
        </script>
        <!-- END: DARK MODE PERSISTENCE SCRIPT -->
    </body>
</html>
