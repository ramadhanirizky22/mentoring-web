@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 space-y-8">
    
    <!-- Submission Header Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-6 space-y-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 uppercase">
                <i class="fas fa-upload mr-1"></i> Pengumpulan Tugas
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $task->title }}</h1>
            <p class="text-xs text-slate-500 flex items-center">
                <i class="far fa-clock mr-1.5 text-rose-500"></i> Batas Pengumpulan: 
                <span class="font-bold text-slate-800 ml-1">{{ \Carbon\Carbon::parse($task->deadline)->setTimezone('Asia/Jakarta')->format('l, d F Y, H:i') }} WIB</span>
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Deskripsi Tugas</h3>
            <p class="text-xs font-medium text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                {{ $task->description }}
            </p>
        </div>

        <!-- File Upload Form -->
        <form action="{{ route('taskSubmit.store', $task->task_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 pt-2">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Unggah Berkas Tugas (PDF / Word / Zip)</label>
                <div class="relative border-2 border-dashed border-indigo-200 hover:border-indigo-500 bg-indigo-50/30 hover:bg-indigo-50/70 rounded-3xl p-8 text-center transition-all cursor-pointer">
                    <input type="file" name="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="space-y-3 pointer-events-none">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center mx-auto text-xl">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">Klik atau seret berkas Anda ke sini</p>
                            <p class="text-[10px] text-slate-400 font-medium mt-1">Ukuran berkas maksimal 10MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('mentee.task', $task->task_id) }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-200 transition-all flex items-center space-x-2">
                    <i class="fas fa-check"></i>
                    <span>Kirim Berkas Sekarang</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection