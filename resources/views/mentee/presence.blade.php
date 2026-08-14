@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 space-y-8" x-data="attendanceManager()">
    
    <!-- Header Banner -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-2">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 uppercase">
            <i class="fas fa-user-check mr-1"></i> Presensi Mentoring
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $attendance->title }}</h1>
        <p class="text-xs text-slate-500 font-medium">Isi presensi sesuai kehadiran Anda pada sesi mentoring ini</p>
    </div>

    <!-- Alert Messages -->
    @if (session('message'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 flex items-start space-x-3 text-emerald-800 text-xs font-semibold">
        <i class="fas fa-check-circle text-emerald-500 text-base mt-0.5 shrink-0"></i>
        <span>{{ session('message') }}</span>
    </div>
    @endif

    @if (session('error'))
    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200/80 flex items-start space-x-3 text-rose-800 text-xs font-semibold">
        <i class="fas fa-exclamation-circle text-rose-500 text-base mt-0.5 shrink-0"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Presence Table Container -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex items-center justify-between">
            <div class="inline-flex items-center px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 font-mono text-xs font-bold border border-indigo-100">
                <i class="far fa-calendar-alt mr-2"></i> {!! strip_tags(nl2br(e($attendanceDetails))) !!}
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-extrabold uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Tanggal & Waktu</th>
                        <th class="p-4">Sesi Presensi</th>
                        <th class="p-4">Status Kehadiran</th>
                        <th class="p-4 text-right">Aksi / Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 text-slate-700 font-mono font-semibold">{!! strip_tags(nl2br(e($attendanceDetails))) !!}</td>
                        <td class="p-4 font-bold text-slate-900">{{ $attendance->title }}</td>
                        <td class="p-4">
                            @if ($status === 'hadir')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <i class="fas fa-check-circle mr-1 text-[10px]"></i> Hadir
                            </span>
                            @elseif ($status === 'izin')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                <i class="fas fa-info-circle mr-1 text-[10px]"></i> Izin
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                <i class="fas fa-question-circle mr-1 text-[10px]"></i> Belum Diisi
                            </span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            @if($status === null)
                            <button @click="showModal = true" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-200 transition-all inline-flex items-center space-x-1.5">
                                <i class="fas fa-edit"></i>
                                <span>Isi Kehadiran</span>
                            </button>
                            @else
                            <span class="text-xs text-slate-400 font-medium">Tercatat Mandiri</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Presensi -->
    <div 
        x-show="showModal" 
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 sm:p-8 space-y-6 relative" @click.away="showModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <i class="fas fa-user-check text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Konfirmasi Kehadiran</h3>
                        <p class="text-xs text-slate-500">Pilih status kehadiran Anda hari ini</p>
                    </div>
                </div>
                <button @click="showModal = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>

            <form id="attendanceForm" method="POST" action="{{ route('presence.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="attendance_id" value="{{ $attendance->attendance_id }}">
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <div class="grid grid-cols-2 gap-4">
                    <label class="relative flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-slate-200 cursor-pointer hover:border-emerald-500 hover:bg-emerald-50/40 transition-all text-center">
                        <input type="radio" name="status" value="hadir" x-model="tempStatus" class="sr-only">
                        <i class="fas fa-check-circle text-2xl text-emerald-500 mb-2"></i>
                        <span class="text-xs font-bold text-slate-800">Hadir</span>
                    </label>

                    <label class="relative flex flex-col items-center justify-center p-4 rounded-2xl border-2 border-slate-200 cursor-pointer hover:border-amber-500 hover:bg-amber-50/40 transition-all text-center">
                        <input type="radio" name="status" value="izin" x-model="tempStatus" class="sr-only">
                        <i class="fas fa-hand text-2xl text-amber-500 mb-2"></i>
                        <span class="text-xs font-bold text-slate-800">Izin</span>
                    </label>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-200 transition-all">
                        Simpan Presensi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function attendanceManager() {
        return {
            showModal: false,
            tempStatus: 'hadir',
        };
    }
</script>
@endsection