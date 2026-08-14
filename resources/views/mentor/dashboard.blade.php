@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">
    
    <!-- Hero Banner -->
    <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 uppercase">
                <i class="fas fa-user-shield mr-1"></i> Dashboard Mentor
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Halo, {{ auth()->user()->name }} 👋</h1>
            <p class="text-xs text-indigo-200 max-w-xl">Selamat datang di portal pendampingan mentoring. Kelola modul, tugas, presensi, dan agenda kegiatan Anda dengan mudah.</p>
        </div>

        <div class="shrink-0 flex items-center space-x-3">
            <a href="{{ route('mentor.logbook') }}" class="px-5 py-3 rounded-2xl bg-white text-indigo-900 hover:bg-indigo-50 font-bold text-xs shadow-lg shadow-black/10 transition-all hover:scale-105 active:scale-95 inline-flex items-center">
                <i class="fas fa-book-open mr-2 text-indigo-600"></i> Isi Logbook Kegiatan
            </a>
        </div>
    </div>

    <!-- Timeline & Action Required Section -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-slate-900 flex items-center">
                <i class="fas fa-stream text-indigo-600 mr-2"></i> Timeline & Perhatian
            </h2>
            <span class="text-xs font-bold text-slate-400">Pemberitahuan Aktivitas</span>
        </div>

        <div class="flex flex-col items-center justify-center p-8 bg-slate-50/70 rounded-2xl border border-dashed border-slate-200 text-center space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-700">Semua Tugas Berjalan Lancar</p>
                <p class="text-[11px] text-slate-400 font-medium mt-0.5">Saat ini tidak ada kegiatan yang membutuhkan tindakan mendesak.</p>
            </div>
        </div>
    </div>

    <!-- Calendar & Agenda Grid -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-slate-900 flex items-center">
                <i class="far fa-calendar-alt text-indigo-600 mr-2"></i> Kalender & Agenda Mentoring
            </h2>

            <button id="btn-tambah-event" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-200 transition-all inline-flex items-center">
                <i class="fas fa-plus mr-1.5"></i> Tambah Event
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <!-- Sidebar Agenda -->
            <div class="lg:col-span-1 p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-6">
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Mini Kalender</h3>
                    <div id="mini-calendar" class="p-2 bg-white rounded-xl border border-slate-200/60 shadow-sm"></div>
                </div>

                <div class="space-y-3 pt-4 border-t border-slate-200/80">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-list-check text-indigo-600 text-sm"></i>
                        <h3 class="text-xs font-extrabold text-slate-800">Agenda & Catatan</h3>
                    </div>

                    <ul id="agenda-list" class="space-y-2 text-xs font-medium">
                        <li class="p-2.5 rounded-xl bg-white border border-slate-200/60 text-slate-700 flex items-center justify-between">
                            <span class="truncate pr-2">• Sesi Mentoring Rutin</span>
                            <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full shrink-0">08:00</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Calendar -->
            <div class="lg:col-span-3 p-4 rounded-2xl bg-white border border-slate-200/80">
                <div id="main-calendar"></div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah Event -->
<div id="modal-tambah-event" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 sm:p-8 space-y-6 relative">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                    <i class="fas fa-calendar-plus text-base"></i>
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Tambah Event Kalender</h3>
                    <p class="text-xs text-slate-500">Jadwalkan kegiatan mentoring baru</p>
                </div>
            </div>
            <button id="btn-close-modal-icon" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times text-base"></i>
            </button>
        </div>

        <form id="form-tambah-event" class="space-y-4">
            <div>
                <label for="event-title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Event</label>
                <input id="event-title" type="text" placeholder="Contoh: Mentoring Modul 3..." required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
            </div>

            <div>
                <label for="event-start" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Waktu Mulai</label>
                <input id="event-start" type="datetime-local" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
            </div>

            <div>
                <label for="event-end" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Waktu Selesai</label>
                <input id="event-end" type="datetime-local" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" id="btn-close-modal" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-200 transition-all">
                    Simpan Event
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof FullCalendar !== 'undefined') {
            // Mini Calendar
            const miniCalendarEl = document.getElementById("mini-calendar");
            if (miniCalendarEl) {
                const miniCalendar = new FullCalendar.Calendar(miniCalendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: false,
                    fixedWeekCount: false,
                    dayMaxEvents: false,
                    height: 'auto',
                });
                miniCalendar.render();
            }

            // Kalender Utama
            const mainCalendarEl = document.getElementById("main-calendar");
            let mainCalendar;
            if (mainCalendarEl) {
                mainCalendar = new FullCalendar.Calendar(mainCalendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    editable: true,
                    events: [
                        { title: 'Sesi Mentoring Rutin', start: new Date().toISOString().split('T')[0] + 'T08:00:00' },
                    ],
                });
                mainCalendar.render();
            }

            // Modal & Event Logic
            const btnTambahEvent = document.getElementById("btn-tambah-event");
            const modalTambahEvent = document.getElementById("modal-tambah-event");
            const btnCloseModal = document.getElementById("btn-close-modal");
            const btnCloseModalIcon = document.getElementById("btn-close-modal-icon");
            const formTambahEvent = document.getElementById("form-tambah-event");
            const agendaList = document.getElementById("agenda-list");

            const closeModal = () => modalTambahEvent.classList.add("hidden");

            if (btnTambahEvent) btnTambahEvent.addEventListener("click", () => modalTambahEvent.classList.remove("hidden"));
            if (btnCloseModal) btnCloseModal.addEventListener("click", closeModal);
            if (btnCloseModalIcon) btnCloseModalIcon.addEventListener("click", closeModal);

            if (formTambahEvent) {
                formTambahEvent.addEventListener("submit", (e) => {
                    e.preventDefault();
                    const title = document.getElementById("event-title").value;
                    const start = document.getElementById("event-start").value;

                    if (!title || !start) return;

                    if (mainCalendar) {
                        mainCalendar.addEvent({ title: title, start: start });
                    }

                    const startDate = new Date(start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    const newAgendaItem = `<li class="p-2.5 rounded-xl bg-white border border-slate-200/60 text-slate-700 flex items-center justify-between"><span class="truncate pr-2">• ${title}</span><span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full shrink-0">${startDate}</span></li>`;
                    agendaList.insertAdjacentHTML('beforeend', newAgendaItem);

                    formTambahEvent.reset();
                    closeModal();
                });
            }
        }
    });
</script>
@endsection
