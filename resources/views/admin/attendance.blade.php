@extends('layouts.admin')

@section('title', 'Rekap Presensi Mentoring')

@section('content')
<div class="space-y-8">
    
    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100">
        <div class="space-y-1">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 uppercase">
                <i class="fas fa-clipboard-check mr-1 text-[9px]"></i> Rekap & Laporan
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Kehadiran & Presensi Mentoring</h1>
            <p class="text-xs text-indigo-200">Monitoring rekapitulasi kehadiran mahasiswa dan cetak berkas PDF per kelompok</p>
        </div>

        <div class="shrink-0 flex items-center space-x-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/20">
            <label for="tahun" class="text-xs font-bold text-indigo-200 uppercase">Tahun Akademik:</label>
            <input 
                id="tahun" 
                type="number" 
                name="tahun_akademik" 
                class="w-20 bg-white/20 border border-white/30 rounded-xl px-2.5 py-1 text-xs font-bold text-white text-center focus:outline-none"
                value="2024" />
        </div>
    </div>

    <!-- Data Table Container -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Rekap Kehadiran Per Kelompok</h2>
                <p class="text-xs text-slate-500">Unduh laporan presensi resmi format PDF</p>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.attendance') }}" class="relative min-w-[260px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fas fa-search text-xs"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari kelompok..." 
                    value="{{ $search ?? '' }}"
                    class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
            </form>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-extrabold uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Kelompok Mentoring</th>
                        <th class="p-4">Jumlah Peserta</th>
                        <th class="p-4">Mentor Pendamping</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($courses as $course)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-bold text-slate-900">
                            {{ $course['name'] }}
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <i class="fas fa-users mr-1 text-[10px]"></i> {{ $course['participants_count'] }} Mahasiswa
                            </span>
                        </td>
                        <td class="p-4 text-slate-700 font-medium">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-[10px] font-bold shrink-0">
                                    {{ strtoupper(substr($course['mentor_name'], 0, 1)) }}
                                </div>
                                <span class="text-xs font-semibold text-slate-800">{{ $course['mentor_name'] }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('admin.attendance.pdf', $course['id']) }}" class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-sm shadow-indigo-200 transition-all hover:scale-105">
                                <i class="fas fa-file-pdf mr-1.5"></i> Unduh Rekap PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 text-sm font-medium">
                            <i class="fas fa-folder-open text-3xl text-slate-300 mb-2 block"></i>
                            Tidak ada data kehadiran mentoring tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection