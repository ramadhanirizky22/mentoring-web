@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="space-y-8" x-data="{ showAddModal: false, showEditModal: false, selectedAnnouncement: {} }">
    
    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-100">
        <div class="space-y-1">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 uppercase">
                <i class="fas fa-bullhorn mr-1 text-[9px]"></i> Pengumuman
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Kelola Pengumuman Mentoring</h1>
            <p class="text-xs text-indigo-200">Unggah berkas PDF pengumuman & petunjuk kegiatan untuk mentee & mentor</p>
        </div>

        <div class="shrink-0">
            <button 
                @click="showAddModal = true"
                class="inline-flex items-center px-4 py-2.5 rounded-2xl bg-white text-indigo-900 hover:bg-indigo-50 font-bold text-xs shadow-lg shadow-black/10 transition-all hover:scale-105 active:scale-95">
                <i class="fas fa-file-upload mr-2 text-indigo-600"></i> Unggah Pengumuman Baru
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
                <h2 class="text-lg font-bold text-slate-900">Daftar Pengumuman Terunggah</h2>
                <p class="text-xs text-slate-500">Total {{ count($announcements) }} berkas pengumuman terpublikasi</p>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-extrabold uppercase text-slate-400 tracking-wider">
                        <th class="p-4">Berkas PDF</th>
                        <th class="p-4">Judul Pengumuman</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($announcements as $announcement)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4">
                            <a href="{{ route('announcement.download', $announcement->file_path) }}" class="inline-flex items-center space-x-2.5 text-indigo-600 hover:text-indigo-800 font-bold text-xs group">
                                <span class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                                <span class="truncate max-w-xs font-mono text-[11px] text-slate-600 group-hover:underline">{{ $announcement->file_path }}</span>
                            </a>
                        </td>
                        <td class="p-4 font-bold text-slate-900">
                            {{ $announcement->title }}
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <button 
                                @click="showEditModal = true; selectedAnnouncement = @js($announcement)"
                                class="inline-flex items-center px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-500 text-amber-700 hover:text-white font-bold text-xs transition-colors">
                                <i class="fas fa-edit mr-1 text-[11px]"></i> Edit Judul
                            </button>

                            <form action="{{ route('announcement.delete', $announcement->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white font-bold text-xs transition-colors">
                                    <i class="fas fa-trash-alt mr-1 text-[11px]"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-slate-400 text-sm font-medium">
                            <i class="fas fa-inbox text-3xl text-slate-300 mb-2 block"></i>
                            Belum ada pengumuman terunggah saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Pengumuman -->
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
                        <i class="fas fa-file-upload text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Unggah Pengumuman</h3>
                        <p class="text-xs text-slate-500">Unggah berkas PDF pengumuman baru</p>
                    </div>
                </div>
                <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>

            <form method="POST" action="/upload-announcement" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Pengumuman</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all" 
                        placeholder="Contoh: Jadwal Pembukaan Mentoring Semester Genap" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Berkas PDF</label>
                    <input 
                        type="file" 
                        name="announcement" 
                        accept=".pdf"
                        required
                        class="w-full text-xs text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer border border-slate-200 rounded-xl p-1 bg-slate-50">
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
                        Unggah Berkas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pengumuman -->
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
                        <h3 class="text-lg font-extrabold text-slate-900">Edit Pengumuman</h3>
                        <p class="text-xs text-slate-500">Ubah judul berkas pengumuman</p>
                    </div>
                </div>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>

            <form method="POST" :action="`{{ route('announcement.update', '') }}/${selectedAnnouncement.id}`" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="edit_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Pengumuman</label>
                    <input 
                        type="text" 
                        id="edit_title" 
                        name="title" 
                        required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all" 
                        x-bind:value="selectedAnnouncement.title" />
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
@endsection