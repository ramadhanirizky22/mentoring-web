@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">
    
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 uppercase">
                <i class="fas fa-tasks mr-1"></i> Pemeriksaan Tugas
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Hasil Pengumpulan Tugas Mentee</h1>
            <p class="text-xs text-indigo-200">Periksa dan unduh berkas jawaban tugas yang telah dikirimkan oleh mentee</p>
        </div>

        <div class="shrink-0">
            <span class="px-4 py-2 rounded-2xl bg-white/10 backdrop-blur-md text-white font-bold text-xs border border-white/20">
                Total {{ count($assignments) }} Berkas Dikumpulkan
            </span>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-slate-900">Daftar Pengumpulan Berkas</h2>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-extrabold uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Nama Mahasiswa</th>
                        <th class="p-4">NIM</th>
                        <th class="p-4 text-right">Berkas Jawaban</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse ($assignments as $assignment)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-bold text-slate-900">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                    {{ strtoupper(substr($assignment->user->name ?? 'M', 0, 2)) }}
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">{{ $assignment->user->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-normal">{{ $assignment->user->email ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 font-mono font-semibold text-slate-700">
                            {{ $assignment->user->nim }}
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('assignment.download', $assignment->assignment_id) }}" class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-sm shadow-indigo-200 transition-all hover:scale-105">
                                <i class="fas fa-download mr-1.5"></i> Unduh Berkas
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-slate-400 text-xs font-medium">
                            <i class="fas fa-inbox text-3xl text-slate-300 mb-2 block"></i>
                            Belum ada mentee yang mengumpulkan tugas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection