<!-- Top Fixed Navbar for Admin -->
<nav class="fixed top-0 z-50 w-full bg-white/90 backdrop-blur-md border-b border-slate-200/80">
    <div class="px-4 py-3 lg:px-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <button data-drawer-target="admin-sidebar" data-drawer-toggle="admin-sidebar" aria-controls="admin-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-slate-500 rounded-xl sm:hidden hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                    <span class="sr-only">Toggle Sidebar</span>
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-500 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-indigo-100 group-hover:scale-105 transition-transform">
                        <i class="fas fa-user-shield text-sm"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-slate-900 text-base leading-tight tracking-tight">Admin <span class="text-indigo-600">Mentoring</span></span>
                        <span class="text-[10px] font-medium text-slate-500 tracking-wider uppercase">Portal Management</span>
                    </div>
                </a>
            </div>

            <!-- User Menu & Quick Actions -->
            <div class="flex items-center space-x-3">
                <a href="/" class="hidden md:inline-flex items-center text-xs font-semibold text-slate-600 hover:text-indigo-600 bg-slate-100 hover:bg-indigo-50 px-3 py-1.5 rounded-lg transition-colors">
                    <i class="fas fa-globe mr-1.5"></i> Lihat Web Utama
                </a>

                @if(Auth::check())
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" type="button" class="flex items-center space-x-2 p-1 rounded-full hover:bg-slate-100 transition-colors focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-xs ring-2 ring-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <span class="hidden sm:block text-xs font-semibold text-slate-700 max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
                    </button>
                    <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-1 z-50 divide-y divide-slate-100" style="display: none;">
                        <div class="px-4 py-2.5">
                            <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-semibold bg-amber-50 text-amber-700 uppercase mt-1">
                                {{ session('role', Auth::user()->role) }}
                            </span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 font-medium transition-colors">
                                <i class="fas fa-sign-out-alt mr-2 text-rose-500"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Admin Sidebar Off-Canvas Drawer -->
<aside id="admin-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform -translate-x-full bg-white border-r border-slate-200/80 sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white flex flex-col justify-between">
        <ul class="space-y-1.5 font-medium text-sm">
            <!-- Section Title -->
            <li class="px-3 pt-2 pb-1 text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                Menu Utama
            </li>

            <!-- Dashboard Link -->
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-chart-pie w-6 text-center mr-2 opacity-70"></i>
                    <span>Dashboard Admin</span>
                </a>
            </li>

            @if(session('role') !== 'pembimbing')
            <li class="px-3 pt-4 pb-1 text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                Kelola Data
            </li>
            <li>
                <a href="{{ route('admin.announcement') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.announcement') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-bullhorn w-6 text-center mr-2 opacity-70"></i>
                    <span>Pengumuman</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pembimbing') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.pembimbing') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-user-tie w-6 text-center mr-2 opacity-70"></i>
                    <span>Data Pembina</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.mentor') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.mentor') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-user-graduate w-6 text-center mr-2 opacity-70"></i>
                    <span>Data Mentor</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.class') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.class') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-users-rectangle w-6 text-center mr-2 opacity-70"></i>
                    <span>Data Kelompok</span>
                </a>
            </li>
            @endif

            <li class="px-3 pt-4 pb-1 text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                Laporan & Absensi
            </li>
            <li>
                <a href="{{ route('admin.attendance') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.attendance*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-calendar-check w-6 text-center mr-2 opacity-70"></i>
                    <span>Kehadiran</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.report') }}" class="flex items-center px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.report*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fas fa-file-invoice w-6 text-center mr-2 opacity-70"></i>
                    <span>Laporan Logbook</span>
                </a>
            </li>
        </ul>

        <!-- Bottom Sidebar Info -->
        <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 mt-6">
            <div class="flex items-center space-x-2">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-xs font-semibold text-slate-700">Sistem Aktif</span>
            </div>
            <p class="text-[10px] text-slate-400 mt-1">Laravel Mentoring v11.x</p>
        </div>
    </div>
</aside>