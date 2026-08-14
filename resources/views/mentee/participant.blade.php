@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">
    
    <!-- Sub-Navbar Header -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 uppercase">
                <i class="fas fa-users mr-1"></i> Anggota Kelompok
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">{{ $course->course_title }}</h1>
            <p class="text-xs text-slate-500">Daftar mahasiswa & mentor yang terdaftar dalam kelompok ini</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex items-center space-x-2 shrink-0">
            <a href="{{ session('role') === 'mentor' ? route('mentor.mentoring', $course->course_slug) : route('courses.show', $course->course_slug) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                <i class="fas fa-book-open mr-1.5 text-slate-500"></i> Materi & Sesi
            </a>
            <a href="{{ route('participant', $course->course_slug) }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white font-bold text-xs shadow-md shadow-indigo-200">
                <i class="fas fa-users mr-1.5"></i> Anggota ({{ count($user_course) }})
            </a>
        </div>
    </div>

    <!-- Participants Table Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900">Daftar Peserta & Pendamping</h2>
            <span class="text-xs text-slate-500">Total {{ count($user_course) }} Pengguna</span>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-extrabold uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Nama Lengkap</th>
                        <th class="p-4">NIM / NIP</th>
                        <th class="p-4">Peran Kelompok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse ($user_course as $participant)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-bold text-slate-900">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($participant['name'], 0, 2)) }}
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">{{ $participant['name'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 font-mono font-semibold text-slate-700">
                            {{ $participant['nim'] }}
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold capitalize
                                {{ $participant['role'] === 'mentor' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-indigo-50 text-indigo-700 border border-indigo-200' }}">
                                <i class="fas mr-1 text-[9px] {{ $participant['role'] === 'mentor' ? 'fa-user-shield' : 'fa-user-graduate' }}"></i>
                                {{ $participant['role'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-slate-400 text-xs font-medium">
                            Belum ada peserta terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection