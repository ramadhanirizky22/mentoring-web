@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
        <div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 uppercase">
                <i class="fas fa-bookmark mr-1 text-[9px]"></i> Ruang Kelas
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Mentoring Saya</h1>
            <p class="text-xs text-slate-500">Daftar kelompok mentoring aktif yang Anda ikuti semester ini</p>
        </div>

        <div class="flex items-center space-x-3 shrink-0">
            <label for="viewMode" class="text-xs font-bold text-slate-500 uppercase tracking-wider hidden sm:block">Tampilan:</label>
            <select id="viewMode" class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                <option value="card" {{ request('view') !== 'list' ? 'selected' : '' }}>Grid Card</option>
                <option value="list" {{ request('view') === 'list' ? 'selected' : '' }}>Daftar List</option>
            </select>
        </div>
    </div>

    <!-- Courses Content -->
    @if (request('view') === 'list')
    <div class="space-y-4">
        @foreach ($courses as $course)
        @php
            $targetUrl = session('role') === 'mentor' 
                ? route('mentor.mentoring', $course->course_slug) 
                : route('courses.show', $course->course_slug);
        @endphp
        <a href="{{ $targetUrl }}" class="group block bg-white rounded-3xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center text-white font-bold text-xl shrink-0 shadow-md shadow-indigo-100 group-hover:scale-105 transition-transform">
                        <i class="fas fa-users-rectangle"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $course->course_title }}</h3>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">
                            <i class="fas fa-user-tie mr-1 text-slate-400"></i> Mentor: <span class="text-slate-700 font-semibold">{{ $course->mentor ? $course->mentor->name : 'Belum ditentukan' }}</span>
                        </p>
                    </div>
                </div>
                <div class="shrink-0 flex items-center">
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 font-bold text-xs group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        Buka Ruang Kelas <i class="fas fa-arrow-right ml-2 text-[10px]"></i>
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($courses as $course)
        @php
            $targetUrl = session('role') === 'mentor' 
                ? route('mentor.mentoring', $course->course_slug) 
                : route('courses.show', $course->course_slug);
        @endphp
        <a href="{{ $targetUrl }}" class="group block bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="relative h-36 bg-gradient-to-tr from-indigo-600 to-violet-700 overflow-hidden">
                    <img src="/images/Rectangle.svg" alt="Group Image" class="w-full h-full object-cover opacity-75 group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-full text-[10px] font-extrabold text-indigo-700 shadow-sm">
                        <i class="fas fa-check-circle text-emerald-500 mr-1"></i> Terdaftar
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <h3 class="text-lg font-extrabold text-slate-900 group-hover:text-indigo-600 transition-colors">
                        {{ $course->course_title }}
                    </h3>

                    <div class="flex items-center space-x-3 pt-2 border-t border-slate-100">
                        <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs shrink-0 ring-2 ring-indigo-50">
                            {{ strtoupper(substr($course->mentor ? $course->mentor->name : 'M', 0, 2)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-slate-800 truncate">{{ $course->mentor ? $course->mentor->name : 'Belum ditentukan' }}</p>
                            <p class="text-[10px] font-medium text-slate-400">Mentor Utama</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 pt-0">
                <div class="w-full py-2.5 px-4 bg-indigo-50 group-hover:bg-indigo-600 text-indigo-700 group-hover:text-white font-bold text-xs rounded-xl transition-all duration-200 flex items-center justify-center space-x-2">
                    <span>Masuk Ke Ruang Mentoring</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif
</div>

<script>
    document.getElementById('viewMode').addEventListener('change', function() {
        const view = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('view', view);
        window.location.href = url.toString();
    });
</script>
@endsection