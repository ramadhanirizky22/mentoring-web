@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">
    
    <!-- Sub-Navbar Header -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 uppercase">
                <i class="fas fa-graduation-cap mr-1"></i> Modul Mentoring
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">{{ $course->course_title }}</h1>
            <p class="text-xs text-slate-500">Mentor: <span class="font-bold text-slate-700">{{ $course->mentor ? $course->mentor->name : 'Belum ditentukan' }}</span></p>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex items-center space-x-2 shrink-0">
            <a href="{{ route('courses.show', $course->course_slug) }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white font-bold text-xs shadow-md shadow-indigo-200">
                <i class="fas fa-book-open mr-1.5"></i> Materi & Tugas
            </a>
            <a href="{{ route('participant', $course->course_slug) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                <i class="fas fa-users mr-1.5 text-slate-500"></i> Anggota
            </a>
            <form action="{{ route('unenroll', $course->course_slug) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin keluar dari kelompok ini?')">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold text-xs transition-colors">
                    <i class="fas fa-sign-out-alt mr-1.5"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Accordion Modules Section -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6" x-data="{ allOpen: true }">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900">Daftar Pertemuan Modul</h2>
            <button @click="allOpen = !allOpen" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                <span x-text="allOpen ? 'Tutup Semua' : 'Buka Semua'"></span>
            </button>
        </div>

        <div class="space-y-4">
            @foreach ($modules as $key => $module)
            <div class="rounded-2xl border border-slate-200/80 overflow-hidden bg-slate-50/50 transition-all" x-data="{ open: true }" x-init="$watch('allOpen', value => open = value)">
                
                <!-- Module Header Button -->
                <button 
                    @click="open = !open"
                    class="w-full p-5 flex items-center justify-between text-left bg-white hover:bg-indigo-50/40 transition-colors border-b border-slate-100">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs shrink-0">
                            {{ $key + 1 }}
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900">{{ $module->module_title }}</h3>
                    </div>
                    <i class="fas fa-chevron-down text-slate-400 text-sm transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                </button>

                <!-- Module Content Body -->
                <div x-show="open" x-collapse class="p-6 space-y-4 bg-white">
                    <div class="text-xs text-slate-600 leading-relaxed font-medium">
                        {{ $module->content }}
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-3">
                        <!-- Presensi / Attendance Link -->
                        @foreach ($module->attendances as $attendance)
                        @if(!empty($attendance))
                        <a href="{{ route('presence', ['module_id' => $module->module_id]) }}" class="group flex items-center space-x-3 p-3.5 rounded-xl bg-emerald-50/60 hover:bg-emerald-100/80 border border-emerald-100 transition-all">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold shrink-0">
                                <i class="fas fa-user-check text-sm"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs font-bold text-slate-900 group-hover:text-emerald-800 transition-colors">{{ $attendance->title }}</span>
                                <span class="text-[10px] text-emerald-600 font-semibold">Klik untuk pengisian presensi</span>
                            </div>
                            <i class="fas fa-arrow-right text-xs text-emerald-500 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        @endif
                        @endforeach

                        <!-- Module File Download -->
                        @if (!empty($module->file_path))
                        <a href="{{ route('module.downloadByFileName', $module->file_path) }}" class="group flex items-center space-x-3 p-3.5 rounded-xl bg-indigo-50/60 hover:bg-indigo-100/80 border border-indigo-100 transition-all">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold shrink-0">
                                <i class="fas fa-file-pdf text-sm"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs font-bold text-slate-900 group-hover:text-indigo-800 transition-colors">Unduh Modul PDF</span>
                                <span class="text-[10px] text-indigo-600 font-mono truncate block">{{ $module->file_path }}</span>
                            </div>
                            <i class="fas fa-download text-xs text-indigo-500 group-hover:translate-y-0.5 transition-transform"></i>
                        </a>
                        @endif

                        <!-- Tasks Section -->
                        @foreach ($module->tasks as $task)
                        @if (!empty($task->file))
                        <a href="{{ route('task.download', $task->task_id) }}" class="group flex items-center space-x-3 p-3.5 rounded-xl bg-violet-50/60 hover:bg-violet-100/80 border border-violet-100 transition-all">
                            <div class="w-8 h-8 rounded-lg bg-violet-100 text-violet-700 flex items-center justify-center font-bold shrink-0">
                                <i class="fas fa-paperclip text-sm"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs font-bold text-slate-900 group-hover:text-violet-800 transition-colors">Unduh Lampiran Tugas</span>
                                <span class="text-[10px] text-violet-600 font-mono truncate block">{{ $task->file }}</span>
                            </div>
                            <i class="fas fa-download text-xs text-violet-500 group-hover:translate-y-0.5 transition-transform"></i>
                        </a>
                        @endif

                        @if (!empty($task))
                        <a href="{{ route('mentee.task', ['task_id' => $task->task_id]) }}" class="group flex items-center space-x-3 p-3.5 rounded-xl bg-amber-50/60 hover:bg-amber-100/80 border border-amber-100 transition-all">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold shrink-0">
                                <i class="fas fa-tasks text-sm"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs font-bold text-slate-900 group-hover:text-amber-800 transition-colors">{{ $task->title ?? 'Tugas Mentoring' }}</span>
                                <span class="text-[10px] text-amber-600 font-medium line-clamp-1">{{ $task->description }}</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-200 text-amber-900 shrink-0">
                                Kumpulkan Tugas <i class="fas fa-arrow-right ml-1 text-[9px]"></i>
                            </span>
                        </a>
                        @endif
                        @endforeach
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection