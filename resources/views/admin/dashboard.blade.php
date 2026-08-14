@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-8">
    
    <!-- Page Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100">
        <div class="space-y-1">
            <div class="flex items-center space-x-2">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-900 uppercase">
                    {{ session('role', Auth::user()->role) }}
                </span>
                <span class="text-xs text-indigo-200">Selamat datang kembali</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ Auth::user()->name }}</h1>
            <p class="text-xs text-indigo-200">Ringkasan statistik data kelompok mentoring & peserta aktif</p>
        </div>
        <div class="shrink-0">
            <a href="{{ route('admin.class') }}" class="inline-flex items-center px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-xs backdrop-blur-md transition-all">
                <i class="fas fa-plus mr-2"></i> Kelola Kelompok
            </a>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 {{ session('role') !== 'pembimbing' ? 'lg:grid-cols-3' : 'lg:grid-cols-2' }} gap-6">
        <!-- Card 1: Total Classes -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jumlah Kelompok</p>
                <h3 class="text-3xl font-extrabold text-slate-900">{{ $totalClasses }}</h3>
                <p class="text-[11px] text-indigo-600 font-semibold">Kelas Mentoring Aktif</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-inner shrink-0">
                <i class="fas fa-layer-group text-2xl"></i>
            </div>
        </div>

        @if (session('role') !== 'pembimbing')
        <!-- Card 2: Total Mentees -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Mahasiswa</p>
                <h3 class="text-3xl font-extrabold text-slate-900">{{ $totalMentees }}</h3>
                <p class="text-[11px] text-emerald-600 font-semibold">Mentee Terdaftar</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner shrink-0">
                <i class="fas fa-user-graduate text-2xl"></i>
            </div>
        </div>
        @endif

        <!-- Card 3: Total Mentors -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Mentor</p>
                <h3 class="text-3xl font-extrabold text-slate-900">{{ $totalMentors }}</h3>
                <p class="text-[11px] text-violet-600 font-semibold">Mentor Pendamping</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-violet-50 border border-violet-100 flex items-center justify-center text-violet-600 shadow-inner shrink-0">
                <i class="fas fa-user-tie text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Group Table Section -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Daftar Kelompok & Cetak Berkas PDF</h2>
                <p class="text-xs text-slate-500">Unduh data daftar mahasiswa mentee per kelompok</p>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-extrabold uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Kelompok</th>
                        <th class="p-4">Mentor Pendamping</th>
                        <th class="p-4">Jumlah Peserta</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($courses as $course)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-bold text-slate-900">
                            {{ $course['name'] }}
                        </td>
                        <td class="p-4 text-slate-600 font-medium">
                            <span class="inline-flex items-center space-x-2">
                                <i class="fas fa-user-circle text-slate-400"></i>
                                <span>{{ $course['mentor_name'] }}</span>
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                                {{ $course['participants_count'] }} Mahasiswa
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('admin.dashboard.download-pdf', $course['id']) }}" class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-sm shadow-indigo-200 transition-all hover:scale-105">
                                <i class="fas fa-file-pdf mr-1.5"></i> Unduh PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 text-sm font-medium">
                            Belum ada kelompok mentoring terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection