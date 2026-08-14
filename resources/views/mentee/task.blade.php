@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 space-y-8">
    
    <!-- Task Header Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
            <div class="space-y-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 uppercase">
                    <i class="fas fa-tasks mr-1"></i> Penugasan Mentoring
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $task->title }}</h1>
            </div>

            <div class="shrink-0 flex flex-col items-start sm:items-end text-xs space-y-1">
                <span class="text-slate-400 font-medium">Batas Pengumpulan:</span>
                <span class="font-bold text-rose-600 bg-rose-50 px-3 py-1 rounded-xl border border-rose-100 flex items-center">
                    <i class="far fa-clock mr-1.5"></i>
                    {{ \Carbon\Carbon::parse($task->deadline)->setTimezone('Asia/Jakarta')->format('l, d M Y, H:i') }} WIB
                </span>
            </div>
        </div>

        <!-- Task Instruction Description -->
        <div class="space-y-2">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Instruksi Tugas</h3>
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs font-medium text-slate-700 leading-relaxed">
                {{ $task->description }}
            </div>
        </div>

        <!-- Action Button -->
        <div class="pt-2 flex items-center justify-end">
            @if ($lastModified)
            <form action="{{ route('assignment.update', $submission_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" required class="hidden" id="fileInput">

                <button type="button" onclick="document.getElementById('fileInput').click()"
                    class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-md shadow-amber-200 transition-all flex items-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>Perbarui Berkas Tugas</span>
                </button>

                <button type="submit" id="submitButton" class="hidden"></button>
            </form>
            @else
            <a href="{{ route('taskSubmit', $task->task_id) }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-200 transition-all inline-flex items-center space-x-2">
                <i class="fas fa-upload"></i>
                <span>Kumpulkan Tugas Sekarang</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Submission Status Details Table -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <h2 class="text-base font-extrabold text-slate-900 flex items-center">
            <i class="fas fa-info-circle text-indigo-600 mr-2"></i> Status Pengumpulan Tugas
        </h2>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left text-xs border-collapse divide-y divide-slate-100">
                <tbody>
                    <tr class="bg-slate-50/50">
                        <td class="py-3.5 px-4 font-bold text-slate-700 w-1/3">Status Pengumpulan</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                {{ $lastModified ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                                <i class="fas mr-1.5 text-[10px] {{ $lastModified ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                {{ $submissionStatus }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3.5 px-4 font-bold text-slate-700">Status Penilaian</td>
                        <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $gradingStatus }}</td>
                    </tr>
                    <tr class="bg-slate-50/50">
                        <td class="py-3.5 px-4 font-bold text-slate-700">Sisa Waktu</td>
                        <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $timeRemaining }}</td>
                    </tr>
                    @if ($lastModified)
                    <tr>
                        <td class="py-3.5 px-4 font-bold text-slate-700">Terakhir Diperbarui</td>
                        <td class="py-3.5 px-4 font-medium text-slate-600">{{ $lastModified }}</td>
                    </tr>
                    @endif
                    @if ($file)
                    <tr class="bg-slate-50/50">
                        <td class="py-3.5 px-4 font-bold text-slate-700">Berkas Yang Dikirim</td>
                        <td class="py-3.5 px-4">
                            <a href="{{ route('assignment.download', $submission_id) }}" class="inline-flex items-center space-x-2 text-indigo-600 hover:text-indigo-800 font-bold hover:underline">
                                <i class="fas fa-file-pdf text-rose-500 text-sm"></i>
                                <span>{{ basename($file) }}</span>
                            </a>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const fileInput = document.getElementById('fileInput');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            document.getElementById('submitButton').click();
        });
    }
</script>
@endsection