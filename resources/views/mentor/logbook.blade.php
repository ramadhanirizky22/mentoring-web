@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6">
    
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 uppercase">
                <i class="fas fa-book-reader mr-1"></i> Logbook Kegiatan
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Catatan & Dokumentasi Kegiatan Mentoring</h1>
            <p class="text-xs text-indigo-200">Isi dan dokumentasikan setiap sesi pelaksanaan kegiatan mentoring kelompok Anda</p>
        </div>

        <div class="shrink-0">
            <button id="openModal" class="px-5 py-3 rounded-2xl bg-white text-indigo-900 hover:bg-indigo-50 font-bold text-xs shadow-lg shadow-black/10 transition-all hover:scale-105 active:scale-95 inline-flex items-center">
                <i class="fas fa-plus mr-2 text-indigo-600"></i> Tambah Logbook Sesi
            </button>
        </div>
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

    <!-- Activity Logbook Feed -->
    <div class="space-y-6">
        @forelse ($reports as $report)
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
            <div class="flex flex-col lg:flex-row gap-6">
                
                <!-- Documentation Photo -->
                <div class="lg:w-1/3 space-y-3">
                    <div class="relative h-52 bg-slate-100 rounded-2xl overflow-hidden border border-slate-200">
                        <img 
                            src="{{ $report->report_photo ? asset('uploads/' . $report->report_photo) : '/images/logbook.svg' }}"
                            alt="Dokumentasi Sesi" 
                            class="w-full h-full object-cover">
                    </div>

                    @if ($report->status !== 'approved' && $report->status !== 'rejected')
                    <form action="{{ route('mentor.report.delete', $report->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 px-3 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white text-xs font-bold transition-all flex items-center justify-center space-x-1.5">
                            <i class="fas fa-trash-alt"></i>
                            <span>Hapus Logbook Ini</span>
                        </button>
                    </form>
                    @endif
                </div>

                <!-- Logbook Details -->
                <div class="lg:w-2/3 space-y-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900">{{ $report->report_name }}</h3>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">
                                <i class="far fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($report->upload_date)->translatedFormat('j F Y') }} 
                                <span class="mx-1.5">•</span> 
                                <i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($report->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($report->end_time)->format('H:i') }} WIB
                            </p>
                        </div>

                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border shrink-0
                            @if ($report->status == 'approved') bg-emerald-50 text-emerald-700 border-emerald-200
                            @elseif ($report->status == 'rejected') bg-rose-50 text-rose-700 border-rose-200
                            @else bg-amber-50 text-amber-700 border-amber-200 @endif">
                            <i class="fas mr-1.5 text-[10px] 
                                @if ($report->status == 'approved') fa-check-circle
                                @elseif ($report->status == 'rejected') fa-times-circle
                                @else fa-spinner fa-spin @endif"></i>
                            {{ $report->status == 'approved' ? 'Disetujui' : ($report->status == 'rejected' ? 'Ditolak' : 'Menunggu Approval') }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Uraian Pelaksanaan Mentoring</p>
                        <p class="text-xs font-medium text-slate-700 leading-relaxed">{{ $report->description }}</p>
                    </div>

                    <!-- Evaluation Comment -->
                    @if ($report->comment)
                    <div class="p-4 rounded-2xl bg-indigo-50/60 border border-indigo-100 space-y-1">
                        <p class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider flex items-center">
                            <i class="fas fa-comment-dots mr-1.5"></i> Catatan Evaluasi Dosen/Pembimbing
                        </p>
                        <p class="text-xs font-semibold text-slate-800">{{ $report->comment }}</p>
                    </div>
                    @endif
                </div>

            </div>
        </div>
        @empty
        <div class="p-12 text-center bg-white rounded-3xl border border-slate-200/80 shadow-sm">
            <i class="fas fa-book-open text-4xl text-slate-300 mb-3"></i>
            <p class="text-sm font-medium text-slate-500">Belum ada logbook kegiatan terdaftar. Klik tombol "+ Tambah Logbook Sesi" untuk menambahkan.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah Logbook -->
<div id="modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-lg w-full p-6 sm:p-8 space-y-6 relative max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                    <i class="fas fa-plus text-base"></i>
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Tambah Logbook Kegiatan</h3>
                    <p class="text-xs text-slate-500">Dokumentasikan pelaksanaan kegiatan mentoring</p>
                </div>
            </div>
            <button id="closeModalIcon" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times text-base"></i>
            </button>
        </div>

        <form action="{{ route('logbook.add') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="report_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama / Judul Kegiatan</label>
                <input type="text" id="report_name" name="report_name" required placeholder="Contoh: Sesi Mentoring 1 - Pemahaman Dasar..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
            </div>

            <div>
                <label for="upload_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Kegiatan</label>
                <input type="date" id="upload_date" name="upload_date" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Waktu Sesi</label>
                <div class="grid grid-cols-2 gap-3">
                    <input name="start_time" type="time" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                    <input name="end_time" type="time" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Uraian Pelaksanaan</label>
                <textarea name="description" id="description" rows="3" required placeholder="Tuliskan jalannya kegiatan mentoring..." class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"></textarea>
            </div>

            <!-- Media Kamera / Foto -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Dokumentasi Foto Sesi</label>
                <button type="button" id="openCameraButton" class="w-full py-3 px-4 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs border border-indigo-200 transition-all flex items-center justify-center space-x-2">
                    <i class="fas fa-camera"></i>
                    <span>Ambil Foto Dokumentasi Kamera</span>
                </button>

                <div id="cameraContainer" class="mt-4 hidden space-y-3 p-3 bg-slate-900 rounded-2xl text-center">
                    <video autoplay class="w-full h-48 object-cover rounded-xl mx-auto"></video>
                    <canvas class="hidden"></canvas>
                    <div class="controls flex items-center justify-center space-x-2">
                        <button type="button" class="screenshot px-4 py-2 bg-indigo-600 text-white font-bold text-xs rounded-xl shadow-md">
                            <i class="fas fa-camera mr-1"></i> Ambil Foto
                        </button>
                    </div>
                </div>

                <div class="screenshot-preview mt-4 hidden space-y-2 text-center">
                    <img id="screenshotImage" alt="Screenshot" class="w-full h-48 object-cover rounded-2xl border border-slate-200">
                    <button id="deleteScreenshotButton" type="button" class="px-4 py-2 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold text-xs rounded-xl transition-all">
                        Hapus Foto
                    </button>
                    <input type="hidden" id="image" name="image">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <button type="button" id="closeModal" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-200 transition-all">
                    Simpan Logbook
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modal');
        const openModalBtn = document.getElementById('openModal');
        const closeModalBtn = document.getElementById('closeModal');
        const closeModalIcon = document.getElementById('closeModalIcon');

        const closeModal = () => modal.classList.add('hidden');

        if (openModalBtn) openModalBtn.addEventListener('click', () => modal.classList.remove('hidden'));
        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (closeModalIcon) closeModalIcon.addEventListener('click', closeModal);
    });
</script>
@endsection