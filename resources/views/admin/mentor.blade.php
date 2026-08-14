@extends('layouts.admin')

@section('title', 'Kelola Mentor')

@section('content')
<div class="space-y-8" x-data="mentorManager()">
    
    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100">
        <div class="space-y-1">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 uppercase">
                <i class="fas fa-user-tie mr-1 text-[9px]"></i> Manajemen Mentor
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Kelola Data Mentor</h1>
            <p class="text-xs text-indigo-200">Tetapkan peran pengguna sebagai mentor pendamping kelompok</p>
        </div>

        <div class="shrink-0">
            <button 
                @click="showAddMentor = true; newMentor = { name: '', nim: '', role: '' };"
                class="inline-flex items-center px-4 py-2.5 rounded-2xl bg-white text-indigo-900 hover:bg-indigo-50 font-bold text-xs shadow-lg shadow-black/10 transition-all hover:scale-105 active:scale-95">
                <i class="fas fa-user-plus mr-2 text-indigo-600"></i> Tambah Mentor Baru
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
                <h2 class="text-lg font-bold text-slate-900">Daftar Mentor Terdaftar</h2>
                <p class="text-xs text-slate-500">Total {{ count($mentors) }} mentor aktif</p>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.mentor') }}" class="relative min-w-[260px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fas fa-search text-xs"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari nama / NIM mentor..." 
                    value="{{ $search ?? '' }}"
                    class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
            </form>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-extrabold uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Nama Lengkap</th>
                        <th class="p-4">NIM SIA</th>
                        <th class="p-4">Peran</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($mentors as $mentor)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-bold text-slate-900">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                    {{ strtoupper(substr($mentor->name, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-slate-900">{{ $mentor->name }}</span>
                                    <span class="text-[11px] font-normal text-slate-400">{{ $mentor->email ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="font-mono text-xs font-semibold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">
                                {{ $mentor->nim }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-violet-50 text-violet-700 border border-violet-100">
                                <i class="fas fa-user-shield mr-1 text-[10px]"></i> Mentor
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <button 
                                @click="deleteMentor({{ $mentor->nim }})"
                                class="inline-flex items-center px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold text-xs transition-colors">
                                <i class="fas fa-trash-alt mr-1 text-[11px]"></i> Hapus Mentor
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 text-sm font-medium">
                            <i class="fas fa-user-slash text-3xl text-slate-300 mb-2 block"></i>
                            Belum ada mentor terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Mentor -->
    <div 
        x-show="showAddMentor" 
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 sm:p-8 space-y-6 relative" @click.away="showAddMentor = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                        <i class="fas fa-user-plus text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Tambah Mentor</h3>
                        <p class="text-xs text-slate-500">Ubah peran mahasiswa menjadi mentor</p>
                    </div>
                </div>
                <button @click="showAddMentor = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('addMentor') }}" class="space-y-4">
                @csrf
                <div class="relative">
                    <label for="mentor_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Cari Nama Mahasiswa</label>
                    <input 
                        type="text" 
                        id="mentor_name" 
                        name="name" 
                        x-model="newMentor.name"
                        @input="fetchSuggestions(newMentor.name)"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                        placeholder="Masukkan nama mahasiswa..." 
                        autocomplete="off" />
                    
                    <ul 
                        x-show="suggestions.length" 
                        class="absolute z-20 w-full bg-white border border-slate-200 rounded-2xl mt-1 max-h-48 overflow-y-auto shadow-xl">
                        <template x-for="suggestion in suggestions" :key="suggestion.id">
                            <li 
                                @click="selectSuggestion(suggestion)"
                                class="p-3 hover:bg-indigo-50 cursor-pointer text-xs font-semibold text-slate-700 flex justify-between items-center">
                                <span x-text="suggestion.name"></span>
                                <span class="text-[10px] text-slate-400 font-mono" x-text="suggestion.nim"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <div>
                    <label for="mentor_nim" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIM SIA</label>
                    <input 
                        type="text" 
                        id="mentor_nim" 
                        name="nim" 
                        x-model="newMentor.nim"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                        placeholder="Contoh: 2103040001" />
                </div>

                <div>
                    <label for="mentor_role" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tetapkan Peran</label>
                    <select 
                        id="mentor_role" 
                        name="role" 
                        x-model="newMentor.role"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                        <option value="mentor" selected>Mentor Pendamping</option>
                        <option value="mente">Mentee (Mahasiswa)</option>
                    </select>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button 
                        type="button" 
                        @click="showAddMentor = false"
                        class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-200 transition-all">
                        Simpan Mentor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function mentorManager() {
        return {
            showAddMentor: false,
            newMentor: { name: '', nim: '', role: 'mentor' },
            suggestions: [],

            fetchSuggestions(query) {
                if (query.length < 1) {
                    this.suggestions = [];
                    return;
                }
                fetch(`/mentor?query=${query}`)
                    .then(response => response.json())
                    .then(data => { this.suggestions = data; });
            },

            selectSuggestion(suggestion) {
                this.newMentor.name = suggestion.name;
                this.newMentor.nim = suggestion.nim;
                this.suggestions = [];
            },

            deleteMentor(nim) {
                Swal.fire({
                    title: 'Yakin ingin menghapus mentor?',
                    text: 'Peran pengguna akan dikembalikan menjadi mentee.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#e11d48',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('/admin/mentor/destroy', { nim: nim })
                            .then((response) => {
                                if (response.data.status === 'success') {
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