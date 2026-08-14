@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 py-6" x-data="{
        isSubmissionModalOpen: false,
        showEditSubmission: false,
        showEditModule: false,
        showAddAttendance: false,
        showUpdateAttendance: false,
        selectedModul: null
    }">
    
    <!-- Sub-Navbar Header -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 uppercase">
                <i class="fas fa-user-shield mr-1"></i> Kelola Kelompok Mentoring
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">{{ $course->course_title }}</h1>
            <p class="text-xs text-slate-500">Tambah & kelola modul, tugas penugasan, presensi, serta unduhan materi</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex items-center space-x-2 shrink-0">
            <a href="{{ route('mentor.mentoring', $course->course_slug) }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white font-bold text-xs shadow-md shadow-indigo-200">
                <i class="fas fa-book-open mr-1.5"></i> Kelola Modul
            </a>
            <a href="{{ route('mentor.mentoring.participant', $course->course_slug) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                <i class="fas fa-users mr-1.5 text-slate-500"></i> Anggota
            </a>
            <form action="{{ route('unenroll', $course->course_slug) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin keluar dari kelompok ini?')">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold text-xs transition-colors">
                    <i class="fas fa-sign-out-alt mr-1.5"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Modules Container -->
    <div x-data="mentoringForm" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        
        <!-- General Add Module Banner -->
        <div class="rounded-2xl border border-indigo-100 overflow-hidden bg-indigo-50/40 p-5 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-bold">
                    <i class="fas fa-plus"></i>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900">Tambah Modul Sesi Baru</h3>
                    <p class="text-xs text-slate-500">Buat materi baru untuk kelompok mentoring ini</p>
                </div>
            </div>
            <button @click="showForm = !showForm" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-sm transition-all">
                <span x-text="showForm ? 'Batal' : '+ Tambah Modul'"></span>
            </button>
        </div>

        <!-- Add Module Form Collapsible -->
        <div x-show="showForm" x-collapse class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Form Modul Baru</h4>
            <form @submit.prevent="submitForm" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Modul</label>
                    <input x-model="formData.module_title" type="text" placeholder="Contoh: Modul 1 - Pengenalan..." required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi / Materi Modul</label>
                    <textarea x-model="formData.content" rows="3" placeholder="Tuliskan uraian materi modul..." required class="w-full p-4 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">File Lampiran Modul (PDF / Doc)</label>
                    <input type="file" @change="handleFileChange" class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 border border-slate-200 rounded-xl p-1 bg-white">
                </div>

                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="showForm = false" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl font-bold text-xs">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-xl font-bold text-xs shadow-md shadow-indigo-200">Simpan Modul</button>
                </div>
            </form>
        </div>

        <!-- Modules List -->
        <div class="space-y-4">
            @foreach ($modules as $key => $module)
            <div class="rounded-2xl border border-slate-200/80 overflow-hidden bg-slate-50/50 transition-all" x-data="{ open: true, dropdown: false }">
                
                <!-- Module Header -->
                <div class="p-5 flex items-center justify-between bg-white border-b border-slate-100">
                    <div class="flex items-center space-x-3.5 cursor-pointer" @click="open = !open">
                        <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs shrink-0">
                            {{ $key + 1 }}
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900">{{ $module->module_title }}</h3>
                    </div>

                    <!-- Dropdown Options Button -->
                    <div class="relative">
                        <button @click="dropdown = !dropdown" class="w-8 h-8 rounded-xl hover:bg-slate-100 text-slate-600 flex items-center justify-center">
                            <i class="fas fa-ellipsis-v text-xs"></i>
                        </button>

                        <div x-show="dropdown" @click.away="dropdown = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white border border-slate-200/80 shadow-xl rounded-2xl py-2 z-20 space-y-1 text-xs font-semibold">
                            <button @click="showEditModule = true; selectedModul = @js($module); dropdown = false" class="w-full text-left px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center">
                                <i class="fas fa-edit mr-2 text-slate-400"></i> Edit Modul
                            </button>

                            @if ($module->tasks?->isEmpty())
                            <button @click="isSubmissionModalOpen = true; selectedModul = @js($module); dropdown = false" class="w-full text-left px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center">
                                <i class="fas fa-plus-circle mr-2 text-slate-400"></i> Tambah Tugas
                            </button>
                            @else
                            <button @click="showEditSubmission = true; selectedModul = @js($module); dropdown = false" class="w-full text-left px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center">
                                <i class="fas fa-tasks mr-2 text-slate-400"></i> Edit Tugas
                            </button>
                            @endif

                            @if ($module->attendances?->isEmpty())
                            <button @click="showAddAttendance = true; selectedModul = @js($module); dropdown = false" class="w-full text-left px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center">
                                <i class="fas fa-user-check mr-2 text-slate-400"></i> Tambah Absensi
                            </button>
                            @else
                            <button @click="showUpdateAttendance = true; selectedModul = @js($module); dropdown = false" class="w-full text-left px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center">
                                <i class="fas fa-calendar-check mr-2 text-slate-400"></i> Edit Absensi
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Module Content Body -->
                <div x-show="open" x-collapse class="p-6 space-y-4 bg-white">
                    <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ $module->content }}</p>

                    <div class="pt-4 border-t border-slate-100 space-y-3">
                        @foreach ($module->attendances as $attendance)
                        @if (!empty($attendance))
                        <a href="{{ route('attendance.show', $attendance->attendance_id) }}" class="group flex items-center space-x-3 p-3 rounded-xl bg-emerald-50/60 hover:bg-emerald-100/80 border border-emerald-100 transition-all">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">
                                <i class="fas fa-clipboard-user"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-900 group-hover:text-emerald-800 flex-1">{{ $attendance->title }}</span>
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-100/80 px-2 py-0.5 rounded-full">Buka Presensi Peserta <i class="fas fa-arrow-right ml-1"></i></span>
                        </a>
                        @endif
                        @endforeach

                        @if (!empty($module->file_path))
                        <a href="{{ route('module.downloadByFileName', $module->file_path) }}" class="group flex items-center space-x-3 p-3 rounded-xl bg-indigo-50/60 hover:bg-indigo-100/80 border border-indigo-100 transition-all">
                            <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs shrink-0">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-900 group-hover:text-indigo-800 flex-1 truncate">{{ $module->file_path }}</span>
                            <i class="fas fa-download text-xs text-indigo-500"></i>
                        </a>
                        @endif

                        @foreach ($module->tasks as $task)
                        @if (!empty($task->file))
                        <a href="{{ route('task.download', $task->task_id) }}" class="group flex items-center space-x-3 p-3 rounded-xl bg-violet-50/60 hover:bg-violet-100/80 border border-violet-100 transition-all">
                            <div class="w-7 h-7 rounded-lg bg-violet-100 text-violet-700 flex items-center justify-center font-bold text-xs shrink-0">
                                <i class="fas fa-paperclip"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-900 group-hover:text-violet-800 flex-1 truncate">{{ $task->file }}</span>
                            <i class="fas fa-download text-xs text-violet-500"></i>
                        </a>
                        @endif

                        @if (!empty($task))
                        <a href="{{ route('submission.show', $task->task_id) }}" class="group flex items-center space-x-3 p-3 rounded-xl bg-amber-50/60 hover:bg-amber-100/80 border border-amber-100 transition-all">
                            <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xs shrink-0">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs font-bold text-slate-900 group-hover:text-amber-800">{{ $task->title ?? 'Tugas Mentoring' }}</span>
                                <span class="text-[10px] text-amber-600 line-clamp-1">{{ $task->description }}</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-200 text-amber-900 shrink-0">
                                Periksa Pengumpulan <i class="fas fa-arrow-right ml-1"></i>
                            </span>
                        </a>
                        @endif
                        @endforeach
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </div>

    <!-- Modals Section -->
    <!-- Modal Add Attendance -->
    <div x-show="showAddAttendance" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 sm:p-8 space-y-6 relative" @click.away="showAddAttendance = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-extrabold text-slate-900">Tambah Sesi Presensi</h3>
                <button @click="showAddAttendance = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('attendance.create') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="module_id" :value="selectedModul ? selectedModul.module_id : ''">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Sesi Presensi</label>
                    <input name="title" type="text" required placeholder="Contoh: Presensi Pertemuan 1..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Waktu Buka Presensi</label>
                    <input type="datetime-local" name="attendance_open" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Batas Akhir Presensi</label>
                    <input type="datetime-local" name="deadline" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900">
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="showAddAttendance = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-bold text-xs rounded-xl shadow-md">Simpan Presensi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Add Submission / Task -->
    <div x-show="isSubmissionModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 sm:p-8 space-y-6 relative" @click.away="isSubmissionModalOpen = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-extrabold text-slate-900">Tambah Penugasan</h3>
                <button @click="isSubmissionModalOpen = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="module_id" :value="selectedModul ? selectedModul.module_id : ''">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Tugas</label>
                    <input name="title" type="text" required placeholder="Contoh: Tugas Mandiri Sesi 1..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi & Instruksi</label>
                    <textarea name="description" rows="3" required placeholder="Instruksi pengumpulan tugas..." class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Batas Pengumpulan (Deadline)</label>
                    <input type="datetime-local" name="deadline" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Berkas Pendukung / Template (Opsional)</label>
                    <input name="file" type="file" class="w-full text-xs border border-slate-200 rounded-xl p-1 bg-slate-50">
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="isSubmissionModalOpen = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-bold text-xs rounded-xl shadow-md">Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Module -->
    <div x-show="showEditModule" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 sm:p-8 space-y-6 relative" @click.away="showEditModule = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-extrabold text-slate-900">Edit Modul</h3>
                <button @click="showEditModule = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
            </div>
            <form :action="`{{ route('module.update', '') }}/${selectedModul ? selectedModul.module_id : ''}`" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Modul</label>
                    <input type="text" x-model="selectedModul ? selectedModul.module_title : ''" name="module_title" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Uraian / Deskripsi</label>
                    <textarea rows="3" x-model="selectedModul ? selectedModul.content : ''" name="content" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ganti Lampiran File</label>
                    <input name="file_path" type="file" class="w-full text-xs border border-slate-200 rounded-xl p-1 bg-slate-50">
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="showEditModule = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-bold text-xs rounded-xl shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('mentoringForm', () => ({
            showForm: false,
            file: null,
            fileName: '',
            formData: {
                module_title: '',
                content: '',
                course_id: '{{ $course->course_id }}',
            },

            handleFileChange(event) {
                const files = event.target.files;
                if (files.length > 0) {
                    this.file = files[0];
                    this.fileName = this.file.name;
                } else {
                    this.file = null;
                    this.fileName = '';
                }
            },

            async submitForm() {
                try {
                    const formData = new FormData();
                    formData.append('module_title', this.formData.module_title);
                    formData.append('content', this.formData.content);
                    formData.append('course_id', this.formData.course_id);
                    if (this.file) {
                        formData.append('file_path', this.file);
                    }

                    await axios.post("{{ route('module.store') }}", formData, {
                        headers: { 'Content-Type': 'multipart/form-data' },
                    });

                    window.location.reload();
                } catch (error) {
                    console.error(error);
                    alert('Terjadi kesalahan saat menyimpan modul.');
                }
            },
        }));
    });
</script>
@endsection