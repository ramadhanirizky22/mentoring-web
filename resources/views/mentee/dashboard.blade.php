@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-4">
    
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-violet-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Halo, {{ Auth::user()->name }} 👋</h1>
            <p class="text-xs sm:text-sm text-indigo-100">Selamat datang di Dashboard Mentoring. Cek jadwal agenda & deadline tugas Anda minggu ini.</p>
        </div>
        <div class="shrink-0">
            <a href="{{ route('mycourse') }}" class="inline-flex items-center px-4 py-2.5 rounded-2xl bg-white/20 hover:bg-white/30 text-white font-bold text-xs backdrop-blur-md border border-white/20 transition-all">
                <i class="fas fa-book-open mr-2"></i> Mentoring Saya
            </a>
        </div>
    </div>

    <!-- Timeline & Upcoming Deadline Section -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                <i class="fas fa-clock text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-900">Agenda & Deadline Mendatang</h2>
                <p class="text-xs text-slate-500">Aktivitas presensi & tugas dalam 7 hari ke depan</p>
            </div>
        </div>

        @if (count($events) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($events as $event)
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70 hover:border-indigo-200 transition-all flex items-start space-x-3.5">
                <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h4 class="text-sm font-bold text-slate-900 truncate">{{ $event['title'] }}</h4>
                    <p class="text-xs font-semibold text-indigo-600 mt-1">
                        <i class="far text-[11px] fa-clock mr-1"></i>
                        {{ \Carbon\Carbon::parse($event['start'])->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="py-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
            <i class="fas fa-calendar-check text-4xl text-slate-300 mb-2"></i>
            <p class="text-sm font-medium text-slate-500">Tidak ada tenggat tugas atau agenda presensi minggu ini.</p>
        </div>
        @endif
    </div>

    <!-- Responsive Calendar Container -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-violet-50 border border-violet-100 flex items-center justify-center text-violet-600">
                    <i class="fas fa-calendar-alt text-lg"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Kalender Kegiatan</h2>
                    <p class="text-xs text-slate-500">Jadwal interaktif aktivitas mentoring</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Agenda (1 col on desktop) -->
            <div class="lg:col-span-1 space-y-6 bg-slate-50/80 p-5 rounded-2xl border border-slate-100">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center">
                        <i class="fas fa-list-ul text-indigo-600 mr-2"></i> Daftar Agenda
                    </h3>
                    @if (count($events) > 0)
                    <ul class="space-y-2.5">
                        @foreach ($events as $event)
                        <li class="p-3 bg-white rounded-xl border border-slate-200/60 shadow-sm">
                            <p class="text-xs font-bold text-slate-800 line-clamp-1">{{ $event['title'] }}</p>
                            <p class="text-[10px] font-semibold text-slate-400 mt-1">
                                {{ \Carbon\Carbon::parse($event['start'])->format('d M, H:i') }}
                            </p>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-xs text-slate-400 font-medium">Belum ada agenda terdaftar.</p>
                    @endif
                </div>
            </div>

            <!-- Main Calendar View (3 cols on desktop) -->
            <div class="lg:col-span-3">
                <div id="main-calendar" class="min-h-[450px]"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const mainCalendarEl = document.getElementById("main-calendar");
        if (mainCalendarEl) {
            const mainCalendar = new FullCalendar.Calendar(mainCalendarEl, {
                initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                editable: false,
                events: @json($events),
            });
            mainCalendar.render();
        }
    });
</script>
@endsection
