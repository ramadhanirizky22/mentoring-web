@if (!request()->is('login'))
<nav class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200/80 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- Brand Logo -->
            <div class="flex items-center space-x-3">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center text-white shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform">
                        <i class="fas fa-graduation-cap text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-slate-900 text-lg leading-tight tracking-tight">Mentoring <span class="text-indigo-600">UMP</span></span>
                        <span class="text-[10px] font-medium text-slate-500 tracking-wider uppercase">Portal Akademik</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="/" class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all {{ request()->is('/') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                    <i class="fas fa-home mr-1.5 opacity-70"></i>Beranda
                </a>
                <a href="/dashboard" class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all {{ request()->is('dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                    <i class="fas fa-chart-line mr-1.5 opacity-70"></i>Dashboard
                </a>
                <a href="{{ route('mycourse') }}" class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all {{ request()->is('mycourse*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                    <i class="fas fa-book-open mr-1.5 opacity-70"></i>Mentoring Saya
                </a>
                @if(Auth::check() && in_array(Auth::user()->role, ['mentor', 'petugas', 'pembimbing']))
                <a href="{{ route('logbook.show') }}" class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all {{ request()->is('logbook*') ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                    <i class="fas fa-clipboard-list mr-1.5 opacity-70"></i>Logbook
                </a>
                @endif
                @if(Auth::check() && in_array(Auth::user()->role, ['petugas', 'pembimbing']))
                <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all {{ request()->is('admin*') ? 'bg-amber-50 text-amber-700 font-semibold shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                    <i class="fas fa-user-shield mr-1.5 opacity-70"></i>Panel Admin
                </a>
                @endif
            </div>

            <!-- Right User Menu / Login -->
            <div class="flex items-center space-x-3">
                <!-- Theme Toggle Button -->
                <button 
                    id="theme-toggle" 
                    type="button" 
                    title="Beralih Mode Gelap/Terang"
                    class="p-2 rounded-xl text-slate-500 hover:text-indigo-600 hover:bg-slate-100 transition-colors focus:outline-none">
                    <i id="theme-toggle-dark-icon" class="fas fa-moon text-sm hidden"></i>
                    <i id="theme-toggle-light-icon" class="fas fa-sun text-sm hidden text-amber-400"></i>
                </button>
                @if(Auth::check())
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" type="button" class="flex items-center space-x-2.5 p-1.5 rounded-full hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500/30">
                        <div class="w-9 h-9 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="hidden lg:flex flex-col text-left pr-1">
                            <span class="text-xs font-semibold text-slate-800 leading-none max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] font-medium text-indigo-600 mt-0.5 capitalize">{{ Auth::user()->role }}</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-slate-400 hidden lg:block transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                    </button>

                    <!-- Dropdown Content -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 divide-y divide-slate-100" style="display: none;">
                        <div class="px-4 py-3">
                            <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs font-medium text-slate-500 truncate">NIM: {{ Auth::user()->nim }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-indigo-50 text-indigo-700 uppercase mt-1.5">
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                        <div class="py-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 font-medium transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2.5 text-rose-500"></i> Keluar (Logout)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all hover:scale-[1.02] active:scale-[0.98]">
                    <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                </a>
                @endif

                <!-- Mobile Hamburger Toggle -->
                <button data-collapse-toggle="navbar-mobile" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                    <span class="sr-only">Buka menu utama</span>
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer Menu -->
    <div class="hidden md:hidden border-t border-slate-100 bg-white/95 px-4 pt-3 pb-4 space-y-1.5 shadow-lg" id="navbar-mobile">
        <a href="/" class="flex items-center px-3.5 py-2.5 rounded-xl text-base font-medium {{ request()->is('/') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
            <i class="fas fa-home w-6 text-center mr-2 text-indigo-500"></i> Beranda
        </a>
        <a href="/dashboard" class="flex items-center px-3.5 py-2.5 rounded-xl text-base font-medium {{ request()->is('dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
            <i class="fas fa-chart-line w-6 text-center mr-2 text-indigo-500"></i> Dashboard
        </a>
        <a href="{{ route('mycourse') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-base font-medium {{ request()->is('mycourse*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
            <i class="fas fa-book-open w-6 text-center mr-2 text-indigo-500"></i> Mentoring Saya
        </a>
        @if(Auth::check() && in_array(Auth::user()->role, ['mentor', 'petugas', 'pembimbing']))
        <a href="{{ route('logbook.show') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-base font-medium {{ request()->is('logbook*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
            <i class="fas fa-clipboard-list w-6 text-center mr-2 text-indigo-500"></i> Logbook Kegiatan
        </a>
        @endif
        @if(Auth::check() && in_array(Auth::user()->role, ['petugas', 'pembimbing']))
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-base font-medium {{ request()->is('admin*') ? 'bg-amber-50 text-amber-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
            <i class="fas fa-user-shield w-6 text-center mr-2 text-amber-500"></i> Panel Admin
        </a>
        @endif
    </div>
</nav>
@endif