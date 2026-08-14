@extends('layouts.admin')

@section('title', 'Kelola Kelompok Mentoring')

@section('content')
<div class="space-y-8" x-data="courseManager()">
    
    <!-- Page Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100">
        <div class="space-y-1">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 uppercase">
                <i class="fas fa-layer-group mr-1 text-[9px]"></i> Manajemen Data
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Kelola Kelompok Mentoring</h1>
            <p class="text-xs text-indigo-200">Tambah, perbarui, dan atur penugasan mentor & pembimbing kelompok</p>
        </div>

        <div class="shrink-0 flex items-center space-x-3">
            <button 
                @click="showAddModal = true; newCourse = { course_title: '', mentor_id: '', pembimbing_id: '' };"
                class="inline-flex items-center px-4 py-2.5 rounded-2xl bg-white text-indigo-900 hover:bg-indigo-50 font-bold text-xs shadow-lg shadow-black/10 transition-all hover:scale-105 active:scale-95">
                <i class="fas fa-plus mr-2 text-indigo-600"></i> Tambah Kelompok Baru
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 flex items-start space-x-3 text-emerald-800 text-xs font-semibold">
        <i class="fas fa-check-circle text-emerald-500 text-base mt-0.5 shrink-0"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200/80 space-y-1 text-rose-800 text-xs font-semibold">
        <div class="flex items-center space-x-2">
            <i class="fas fa-exclamation-triangle text-rose-500 text-base shrink-0"></i>
            <span>Terdapat beberapa kesalahan:</span>
        </div>
        <ul class="list-disc list-inside pl-6 space-y-0.5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Data Table Container -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Daftar Kelompok Terdaftar</h2>
                <p class="text-xs text-slate-500">Total {{ count($courses) }} kelompok mentoring aktif</p>
            </div>

            <!-- Search Bar -->
            <div class="relative min-w-[260px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fas fa-search text-xs"></i>
                </div>
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    placeholder="Cari kelompok / mentor..."
                    class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-extrabold uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Kelompok</th>
                        <th class="p-4">Jumlah Peserta</th>
                        <th class="p-4">Mentor Pendamping</th>
                        <th class="p-4">Pembimbing / Dosen</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($courses as $course)
                    <tr 
                        x-show="searchQuery === '' || '{{ strtolower($course->course_title) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($course->mentor->name ?? '') }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($course->pembimbing->name ?? '') }}'.includes(searchQuery.toLowerCase())"
                        class="hover:bg-slate-50/80 transition-colors">
                        
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">{{ $course->course_title }}</span>
                            <span class="text-[10px] text-slate-400 font-mono">ID: {{ $course->course_id }}</span>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <i class="fas fa-users mr-1 text-[10px]"></i> {{ $course->users_count }} Peserta
                            </span>
                        </td>
                        <td class="p-4 text-slate-700 font-medium">
                            @if ($course->mentor)
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-[10px] font-bold shrink-0">
                                    {{ strtoupper(substr($course->mentor->name, 0, 1)) }}
                                </div>
                                <span class="text-xs font-semibold text-slate-800">{{ $course->mentor->name }}</span>
                            </div>
                            @else
                            <span class="text-xs text-slate-400 italic">Belum ada mentor</span>
                            @endif
                        </td>
                        <td class="p-4 text-slate-700 font-medium">
                            @if ($course->pembimbing)
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 rounded-full bg-violet-100 text-violet-700 flex items-center justify-center text-[10px] font-bold shrink-0">
                                    {{ strtoupper(substr($course->pembimbing->name, 0, 1)) }}
                                </div>
                                <span class="text-xs font-semibold text-slate-800">{{ $course->pembimbing->name }}</span>
                            </div>
                            @else
                            <span class="text-xs text-slate-400 italic">Belum ada pembimbing</span>
                            @endif
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <button 
                                data-id="{{ $course->course_id }}"
                                data-title="{{ $course->course_title }}"
                                data-mentor-id="{{ $course->mentor->id ?? '' }}"
                                data-pembimbing-id="{{ $course->pembimbing->id ?? '' }}"
                                @click="openEditModal($event)"
                                class="inline-flex items-center px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-500 text-amber-700 hover:text-white font-bold text-xs transition-colors">
                                <i class="fas fa-edit mr-1 text-[11px]"></i> Edit
                            </button>

                            <button 
                                @click="deleteCourse('{{ $course->course_id }}')"
                                class="inline-flex items-center px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold text-xs transition-colors">
                                <i class="fas fa-trash-alt mr-1 text-[11px]"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400 text-sm font-medium">
                            <i class="fas fa-folder-open text-3xl text-slate-300 mb-2 block"></i>
                            Belum ada data kelompok terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Data Kelas -->
    <div 
        x-show="showAddModal" 
        x-cloak 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 sm:p-8 space-y-6 relative" @click.away="showAddModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                        <i class="fas fa-plus text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Tambah Kelompok</h3>
                        <p class="text-xs text-slate-500">Buat kelompok mentoring baru</p>
                    </div>
                </div>
                <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('store.course') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="add_course_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Kelompok</label>
                    <input 
                        type="text" 
                        id="add_course_title" 
                        name="course_title"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                        placeholder="Contoh: Kelompok Mentoring A1" />
                </div>

                <div>
                    <label for="add_mentor_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Mentor Pendamping</label>
                    <select 
                        id="add_mentor_name" 
                        name="mentor_id"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                        <option value="" disabled selected>-- Pilih Mentor --</option>
                        @foreach ($mentors as $mentor)
                        <option value="{{ $mentor->id }}">{{ $mentor->name }} ({{ $mentor->nim }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="add_pembimbing_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Pembimbing / Dosen</label>
                    <select 
                        id="add_pembimbing_name" 
                        name="pembimbing_id"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                        <option value="" selected>-- Pilih Pembimbing (Opsional) --</option>
                        @foreach ($pembimbings as $pembimbing)
                        <option value="{{ $pembimbing->id }}">{{ $pembimbing->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button 
                        type="button" 
                        @click="showAddModal = false"
                        class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-200 transition-all">
                        Simpan Kelompok
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Data Kelas -->
    <div 
        x-show="showEditModal" 
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 sm:p-8 space-y-6 relative" @click.away="showEditModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <i class="fas fa-edit text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Edit Kelompok</h3>
                        <p class="text-xs text-slate-500">Perbarui rincian data kelompok</p>
                    </div>
                </div>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>

            <form @submit.prevent="updateData" class="space-y-4">
                @csrf
                <input type="hidden" x-model="editCourse.course_id" />
                
                <div>
                    <label for="edit_course_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Kelompok</label>
                    <input 
                        type="text" 
                        id="edit_course_title" 
                        x-model="editCourse.course_title"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all" />
                </div>

                <div>
                    <label for="edit_mentor_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Mentor Pendamping</label>
                    <select 
                        id="edit_mentor_name" 
                        x-model="editCourse.mentor_id"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                        <option value="" disabled>-- Pilih Mentor --</option>
                        @foreach ($mentors as $mentor)
                        <option value="{{ $mentor->id }}">{{ $mentor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="edit_pembimbing_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pembimbing / Dosen</label>
                    <select 
                        id="edit_pembimbing_name" 
                        x-model="editCourse.pembimbing_id"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                        <option value="" disabled>-- Pilih Pembimbing --</option>
                        @foreach ($pembimbings as $pembimbing)
                        <option value="{{ $pembimbing->id }}">{{ $pembimbing->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button 
                        type="button" 
                        @click="showEditModal = false"
                        class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-200 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function courseManager() {
        return {
            searchQuery: '',
            showAddModal: false,
            showEditModal: false,
            editCourse: {
                course_id: null,
                course_title: '',
                mentor_id: null,
                pembimbing_id: null,
            },

            openEditModal(event) {
                const button = event.currentTarget;
                this.editCourse.course_id = button.getAttribute('data-id');
                this.editCourse.course_title = button.getAttribute('data-title');
                this.editCourse.mentor_id = button.getAttribute('data-mentor-id');
                this.editCourse.pembimbing_id = button.getAttribute('data-pembimbing-id');
                this.showEditModal = true;
            },

            updateData() {
                const csrfToken = document.querySelector('form input[name="_token"]').value;
                if (!this.editCourse.course_id) return;

                fetch(`/admin/course/update/${this.editCourse.course_id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        course_title: this.editCourse.course_title,
                        mentor_id: this.editCourse.mentor_id,
                        pembimbing_id: this.editCourse.pembimbing_id,
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    this.showEditModal = false;
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data kelompok berhasil diperbarui.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    setTimeout(() => location.reload(), 1500);
                })
                .catch((error) => {
                    Swal.fire('Error!', 'Gagal memperbarui data.', 'error');
                });
            },

            deleteCourse(id) {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#e11d48',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`/admin/course/delete/${id}`)
                            .then((response) => {
                                if (response.status === 200) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.data.message,
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false,
                                    });
                                    setTimeout(() => location.reload(), 1500);
                                } else {
                                    Swal.fire('Gagal!', response.data.message, 'error');
                                }
                            })
                            .catch((error) => {
                                Swal.fire(
                                    'Gagal!',
                                    error.response?.data?.message || 'Terjadi kesalahan.',
                                    'error'
                                );
                            });
                    }
                });
            }
        };
    }
</script>
@endsection