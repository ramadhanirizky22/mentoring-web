@extends('layouts.admin')

@section('title', 'Kelola Pembina & Dosen')

@section('content')
<div class="space-y-8" x-data="mentorManager()">
    
    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100">
        <div class="space-y-1">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 uppercase">
                <i class="fas fa-chalkboard-teacher mr-1 text-[9px]"></i> Pembimbing & Dosen
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Kelola Data Pembina / Dosen</h1>
            <p class="text-xs text-indigo-200">Kelola akun dan tetapkan peran pembimbing mentoring</p>
        </div>

        <div class="shrink-0">
            <button 
                @click="showAddMentor = true; newMentor = { name: '', nim: '', role: 'pembimbing' };"
                class="inline-flex items-center px-4 py-2.5 rounded-2xl bg-white text-indigo-900 hover:bg-indigo-50 font-bold text-xs shadow-lg shadow-black/10 transition-all hover:scale-105 active:scale-95">
                <i class="fas fa-plus mr-2 text-indigo-600"></i> Tambah Pembina Baru
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
                <h2 class="text-lg font-bold text-slate-900">Daftar Pembina Terdaftar</h2>
                <p class="text-xs text-slate-500">Total {{ count($pembimbings) }} pembina aktif</p>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.pembimbing') }}" class="relative min-w-[260px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fas fa-search text-xs"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari nama / NIK / NIP..." 
                    value="{{ $search ?? '' }}"
                    class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
            </form>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-extrabold uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Nama Lengkap</th>
                        <th class="p-4">NIK / NIP / Kode Dosen</th>
                        <th class="p-4">Peran System</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($pembimbings as $pembimbing)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-bold text-slate-900">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-violet-500 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                    {{ strtoupper(substr($pembimbing->name, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-slate-900">{{ $pembimbing->name }}</span>
                                    <span class="text-[11px] font-normal text-slate-400">{{ $pembimbing->email ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="font-mono text-xs font-semibold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">
                                {{ $pembimbing->nim }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <i class="fas fa-graduation-cap mr-1 text-[10px]"></i> Pembimbing
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <button 
                                @click="deleteMentor({{ $pembimbing->nim }})"
                                class="inline-flex items-center px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold text-xs transition-colors">
                                <i class="fas fa-trash-alt mr-1 text-[11px]"></i> Hapus Pembina
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 text-sm font-medium">
                            <i class="fas fa-user-slash text-3xl text-slate-300 mb-2 block"></i>
                            Belum ada data pembina terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Pembimbing -->
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
                        <i class="fas fa-plus text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Tambah Pembina</h3>
                        <p class="text-xs text-slate-500">Tetapkan pengguna sebagai pembimbing/dosen</p>
                    </div>
                </div>
                <button @click="showAddMentor = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.addPembimbing') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="mentor_nim" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIK / NIP Pembina SIA</label>
                    <input 
                        type="text" 
                        id="mentor_nim" 
                        name="nim" 
                        x-model="newMentor.nim"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                        placeholder="Masukkan NIK atau NIP pembina..." />
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
                        Simpan Pembina
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
            newMentor: { name: '', nim: '', role: 'pembimbing' },

            deleteMentor(nim) {
                Swal.fire({
                    title: 'Yakin ingin menghapus pembina?',
                    text: 'Peran pengguna akan dihapus dari pembina.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#e11d48',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('/admin/pembimbing/destroy', { nim: nim })
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