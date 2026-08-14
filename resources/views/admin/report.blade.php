@extends('layouts.admin')

@section('title', 'Laporan & Logbook Mentoring')

@section('content')
<div class="space-y-8">
    
    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100">
        <div class="space-y-1">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 uppercase">
                <i class="fas fa-book-reader mr-1 text-[9px]"></i> Laporan Logbook
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Verifikasi Logbook Kegiatan</h1>
            <p class="text-xs text-indigo-200">Tinjau laporan pelaksanaan mentoring kelompok & berikan persetujuan</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 flex items-start space-x-3 text-emerald-800 text-xs font-semibold">
        <i class="fas fa-check-circle text-emerald-500 text-base mt-0.5 shrink-0"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Reports Container -->
    <div class="space-y-4">
        @forelse ($courses as $course)
        <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm transition-all" x-data="{ open: false }">
            
            <!-- Group Header Toggle -->
            <button 
                @click="open = !open" 
                class="w-full p-6 flex items-center justify-between bg-slate-50/70 hover:bg-indigo-50/50 text-left transition-colors">
                
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm shrink-0">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">{{ $course->course_title }}</h3>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">
                            Total <span class="font-bold text-slate-700">{{ count($course->reports) }}</span> laporan kegiatan terunggah
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <span class="text-xs font-bold text-slate-400 uppercase hidden sm:block" x-text="open ? 'Tutup' : 'Lihat Laporan'"></span>
                    <i class="fas fa-chevron-down text-slate-400 text-sm transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                </div>
            </button>

            <!-- Group Reports List -->
            <div x-show="open" x-collapse class="p-6 border-t border-slate-100 space-y-6">
                @forelse ($course->reports as $report)
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70 space-y-6" x-data="{ editMode: false }">
                    <div class="flex flex-col lg:flex-row gap-6">
                        
                        <!-- Activity Photo Preview -->
                        <div class="lg:w-1/3 space-y-3">
                            <div class="relative h-48 bg-slate-200 rounded-2xl overflow-hidden border border-slate-200">
                                <img 
                                    src="{{ $report->report_photo ? asset('uploads/' . $report->report_photo) : '/images/logbook.svg' }}"
                                    alt="Dokumentasi Kegiatan" 
                                    class="w-full h-full object-cover">
                            </div>
                            <button 
                                @click="editMode = !editMode" 
                                class="w-full py-2 px-3 rounded-xl bg-amber-50 hover:bg-amber-500 text-amber-700 hover:text-white text-xs font-bold transition-all flex items-center justify-center space-x-2">
                                <i class="fas fa-pen-to-square"></i>
                                <span x-text="editMode ? 'Batal Edit' : 'Edit Status & Komentar'"></span>
                            </button>
                        </div>

                        <!-- Activity Details -->
                        <div class="lg:w-2/3 space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="text-base font-extrabold text-slate-900">{{ $report->report_name }}</h4>
                                    <p class="text-xs font-medium text-slate-500 mt-0.5">
                                        <i class="far fa-calendar mr-1"></i> {{ $report->upload_date }} 
                                        <span class="mx-1.5">•</span> 
                                        <i class="far fa-clock mr-1"></i> {{ $report->start_time }} - {{ $report->end_time }} WIB
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
                            <div class="p-4 rounded-xl bg-white border border-slate-200/80 space-y-1">
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Uraian Kegiatan</p>
                                <p class="text-xs font-medium text-slate-700 leading-relaxed">{{ $report->description }}</p>
                            </div>

                            <!-- Comment Preview -->
                            @if ($report->comment)
                            <div class="p-4 rounded-xl bg-indigo-50/60 border border-indigo-100 space-y-1">
                                <p class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider flex items-center">
                                    <i class="fas fa-comment-dots mr-1.5"></i> Catatan Evaluasi Pembimbing
                                </p>
                                <p class="text-xs font-semibold text-slate-800">{{ $report->comment }}</p>
                            </div>
                            @endif

                            <!-- Edit Form Section -->
                            <div x-show="editMode" x-collapse class="pt-4 border-t border-slate-200 space-y-4">
                                <form action="{{ route('admin.update.report', $report->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Keputusan Status</label>
                                        <div class="flex items-center space-x-4">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="radio" name="status" value="approved" class="text-indigo-600 focus:ring-indigo-500" {{ $report->status == 'approved' ? 'checked' : '' }}>
                                                <span class="ml-2 text-xs font-bold text-emerald-700">Setujui Laporan</span>
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="radio" name="status" value="rejected" class="text-rose-600 focus:ring-rose-500" {{ $report->status == 'rejected' ? 'checked' : '' }}>
                                                <span class="ml-2 text-xs font-bold text-rose-700">Tolak Laporan</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="comment_{{ $report->id }}" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Berikan Catatan / Feedback</label>
                                        <textarea 
                                            id="comment_{{ $report->id }}"
                                            name="comment" 
                                            rows="2" 
                                            class="w-full p-3 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600"
                                            placeholder="Tuliskan catatan evaluasi kegiatan ini...">{{ $report->comment }}</textarea>
                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <button type="button" @click="editMode = false" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition-all">
                                            Batal
                                        </button>
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-md shadow-indigo-200 transition-all">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                @empty
                <div class="py-6 text-center text-slate-400 text-xs font-medium">
                    Belum ada logbook kegiatan terunggah untuk kelompok ini.
                </div>
                @endforelse
            </div>
        </div>
        @empty
        <div class="p-12 text-center bg-white rounded-3xl border border-slate-200/80">
            <i class="fas fa-folder-open text-4xl text-slate-300 mb-3"></i>
            <p class="text-sm font-medium text-slate-500">Belum ada kelompok atau data laporan kegiatan.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection