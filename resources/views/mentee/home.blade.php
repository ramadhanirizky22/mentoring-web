@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">

    <!-- Hero Banner Section -->
    <div class="relative bg-gradient-to-r from-indigo-700 via-indigo-600 to-violet-700 rounded-3xl p-8 sm:p-12 text-white shadow-xl shadow-indigo-200/50 overflow-hidden">
        <!-- Background Pattern Decorator -->
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-40 top-0 w-48 h-48 bg-violet-400/20 rounded-full blur-xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-2xl space-y-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-md border border-white/20">
                <i class="fas fa-sparkles mr-1.5 text-amber-300"></i> Portal Resmi Mentoring UMP
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Tingkatkan Kompetensi & Kerohanian Bersama Mentor
            </h1>
            <p class="text-sm sm:text-base text-indigo-100 font-normal leading-relaxed">
                Temukan kelompok mentoring Anda, akses materi modul terbaru, kumpulkan tugas tepat waktu, dan pantau rekaman keikutsertaan Anda.
            </p>
        </div>
    </div>

    <!-- Announcement Section -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                <i class="fas fa-bullhorn text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-900">Pengumuman Terbaru</h2>
                <p class="text-xs text-slate-500">Informasi dan petunjuk penting terkait kegiatan mentoring</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
            @forelse ($announcements as $announcement)
            <a href="{{ route('announcement.download', $announcement->file_path) }}" class="group block p-4 rounded-2xl bg-slate-50 hover:bg-indigo-50/70 border border-slate-200/70 hover:border-indigo-200 transition-all duration-200">
                <div class="flex items-start space-x-3.5">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-pdf text-xl"></i>
                    </div>
                    <div class="flex-grow min-w-0">
                        <h4 class="text-sm font-bold text-slate-800 group-hover:text-indigo-600 truncate transition-colors">{{ $announcement->title }}</h4>
                        <p class="text-[11px] font-medium text-slate-400 mt-1 flex items-center">
                            <i class="fas fa-download mr-1 text-[10px]"></i> Klik untuk unduh berkas
                        </p>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full py-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                <i class="fas fa-inbox text-3xl text-slate-300 mb-2"></i>
                <p class="text-sm font-medium text-slate-500">Belum ada pengumuman terbaru saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Course Group List Section -->
    <div class="space-y-6" x-data="{ search: '' }">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Daftar Kelompok Mentoring</h2>
                <p class="text-xs text-slate-500">Pilih dan mendaftar pada kelompok mentoring Anda</p>
            </div>

            <!-- Search Input Bar -->
            <div class="relative min-w-[280px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fas fa-search text-sm"></i>
                </div>
                <input
                    type="text"
                    x-model="search"
                    placeholder="Cari kelompok atau mentor..."
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 shadow-sm transition-all">
            </div>
        </div>

        <!-- Group Grid Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($courses as $course)
            <div 
                x-show="search === '' || '{{ strtolower($course->course_title) }}'.includes(search.toLowerCase()) || '{{ strtolower($course->mentor ? $course->mentor->name : '') }}'.includes(search.toLowerCase())"
                class="group bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300 flex flex-col justify-between">
                
                <div>
                    <!-- Card Top Cover Image -->
                    <div class="relative h-36 bg-gradient-to-tr from-indigo-500 to-violet-600 overflow-hidden">
                        <img src="/images/Rectangle.svg" alt="Group Image" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-full text-[10px] font-bold text-indigo-700 shadow-sm">
                            <i class="fas fa-users mr-1"></i> Kelompok
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 space-y-3">
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-1">
                            {{ $course->course_title }}
                        </h3>

                        <div class="flex items-center space-x-3 pt-1">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs shrink-0 ring-2 ring-indigo-50">
                                {{ strtoupper(substr($course->mentor ? $course->mentor->name : 'M', 0, 2)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-[11px] font-bold text-slate-700 truncate">{{ $course->mentor ? $course->mentor->name : 'Belum ditentukan' }}</p>
                                <p class="text-[10px] font-medium text-slate-400">Mentor Pendamping</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer Action -->
                <div class="p-5 pt-0">
                    <a href="{{ route('enroll', $course->course_slug) }}" class="w-full py-2.5 px-4 bg-slate-100 hover:bg-indigo-600 text-slate-700 hover:text-white font-bold text-xs rounded-xl transition-all duration-200 flex items-center justify-center space-x-2 group-hover:shadow-md group-hover:shadow-indigo-200">
                        <span>Lihat Detail Kelompok</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection