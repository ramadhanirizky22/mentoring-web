<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard - Mentoring Web UMP' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome & FullCalendar -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

    <!-- Flowbite & Alpine -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* FullCalendar Custom Aesthetic Styling */
        .fc {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        .fc .fc-toolbar {
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1.25rem !important;
        }
        .fc .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            letter-spacing: -0.02em;
        }
        .fc .fc-button-primary {
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
            color: #334155 !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            border-radius: 0.75rem !important;
            padding: 0.5rem 0.875rem !important;
            box-shadow: none !important;
            transition: all 0.2s ease !important;
            text-transform: capitalize !important;
        }
        .fc .fc-button-primary:hover {
            background-color: #4f46e5 !important;
            border-color: #4f46e5 !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        .fc .fc-button-primary:disabled {
            opacity: 0.5;
        }
        .fc .fc-button-active {
            background-color: #4f46e5 !important;
            border-color: #4f46e5 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25) !important;
        }
        .fc-theme-standard th {
            background-color: #f8fafc !important;
            border-color: #f1f5f9 !important;
            padding: 0.75rem 0.5rem !important;
        }
        .fc-col-header-cell-cushion {
            font-size: 0.7rem !important;
            font-weight: 800 !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b !important;
            text-decoration: none !important;
        }
        .fc-theme-standard td, .fc-theme-standard th {
            border-color: #f1f5f9 !important;
        }
        .fc-daygrid-day-number {
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            color: #475569 !important;
            text-decoration: none !important;
            padding: 0.35rem 0.5rem !important;
        }
        .fc-day-today {
            background-color: rgba(99, 102, 241, 0.05) !important;
        }
        .fc-day-today .fc-daygrid-day-number {
            background-color: #4f46e5 !important;
            color: #ffffff !important;
            border-radius: 9999px;
            width: 1.6rem;
            height: 1.6rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0.25rem;
        }
        .fc-event {
            border-radius: 0.5rem !important;
            border: none !important;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%) !important;
            padding: 0.25rem 0.5rem !important;
            font-size: 0.7rem !important;
            font-weight: 700 !important;
            box-shadow: 0 2px 4px rgba(79, 70, 229, 0.15) !important;
            transition: transform 0.15s ease, box-shadow 0.15s ease !important;
            cursor: pointer;
        }
        /* Dark Mode Overrides */
        html.dark body {
            background-color: #090d16 !important;
            color: #f1f5f9 !important;
        }
        html.dark nav, html.dark aside, html.dark .bg-white {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
            color: #f8fafc !important;
        }
        html.dark .bg-slate-50, html.dark .bg-slate-100 {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        html.dark .text-slate-900, html.dark .text-slate-800, html.dark .text-slate-700 {
            color: #f8fafc !important;
        }
        html.dark .text-slate-600, html.dark .text-slate-500 {
            color: #94a3b8 !important;
        }
        html.dark .fc .fc-toolbar-title {
            color: #f8fafc !important;
        }
        html.dark .fc .fc-button-primary {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        html.dark .fc-theme-standard th, html.dark .fc-theme-standard td {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
        }
        html.dark .fc-daygrid-day-number {
            color: #cbd5e1 !important;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased min-h-screen selection:bg-indigo-600 selection:text-white transition-colors duration-200">
    
    <!-- Admin Sidebar Navigation -->
    <x-sidebar />

    <!-- Page Content Wrapper -->
    <div class="p-4 sm:ml-64 pt-20 pb-12 min-h-screen bg-slate-50 dark:bg-slate-950 transition-all duration-300">
        <main class="max-w-7xl mx-auto space-y-6">
            @yield('content')
        </main>
    </div>

    <!-- Dark Mode Toggle Script -->
    <script>
        (function() {
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
            const themeToggleBtn = document.getElementById('theme-toggle');

            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                if (themeToggleLightIcon) themeToggleLightIcon.classList.remove('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                if (themeToggleDarkIcon) themeToggleDarkIcon.classList.remove('hidden');
            }

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function() {
                    if (themeToggleDarkIcon) themeToggleDarkIcon.classList.toggle('hidden');
                    if (themeToggleLightIcon) themeToggleLightIcon.classList.toggle('hidden');

                    if (localStorage.getItem('color-theme')) {
                        if (localStorage.getItem('color-theme') === 'light') {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('color-theme', 'dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('color-theme', 'light');
                        }
                    } else {
                        if (document.documentElement.classList.contains('dark')) {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('color-theme', 'light');
                        } else {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('color-theme', 'dark');
                        }
                    }
                });
            }
        })();
    </script>
</body>
</html>
