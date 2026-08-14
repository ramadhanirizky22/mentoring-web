@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">
    
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 uppercase">
                <i class="fas fa-user-check mr-1"></i> Rekap Presensi Mentee
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Daftar Kehadiran Sesi Mentoring</h1>
            <p class="text-xs text-indigo-200">Monitoring rekapitulasi pengisian presensi mandiri mentee per sesi</p>
        </div>

        <div class="shrink-0">
            <span class="px-4 py-2 rounded-2xl bg-white/10 backdrop-blur-md text-white font-bold text-xs border border-white/20">
                Total {{ count($attendances) }} Data Presensi
            </span>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-slate-900">Rekapitulasi Kehadiran Mahasiswa</h2>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-extrabold uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Nama Mahasiswa</th>
                        <th class="p-4">NIM</th>
                        <th class="p-4">Status Kehadiran</th>
                        <th class="p-4">Waktu Presensi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse ($attendances as $attendance)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-bold text-slate-900">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                    {{ strtoupper(substr($attendance->user->name ?? 'M', 0, 2)) }}
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">{{ $attendance->user->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 font-mono font-semibold text-slate-700">
                            {{ $attendance->user->nim }}
                        </td>
                        <td class="p-4">
                            @if (strtolower($attendance->status) === 'hadir')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <i class="fas fa-check-circle mr-1 text-[10px]"></i> Hadir
                            </span>
                            @elseif (strtolower($attendance->status) === 'izin')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                <i class="fas fa-info-circle mr-1 text-[10px]"></i> Izin
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 capitalize">
                                {{ $attendance->status }}
                            </span>
                            @endif
                        </td>
                        <td class="p-4 font-mono text-slate-600 font-medium">
                            <i class="far fa-clock text-slate-400 mr-1"></i> {{ $attendance->formatted_date }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 text-xs font-medium">
                            <i class="fas fa-folder-open text-3xl text-slate-300 mb-2 block"></i>
                            Belum ada data presensi yang diisi mentee.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection