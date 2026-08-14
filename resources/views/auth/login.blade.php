@extends('layouts.app')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 sm:px-6 py-12 relative overflow-hidden">
    
    <!-- Decorative background glow spheres -->
    <div class="absolute -top-24 -left-20 w-80 h-80 bg-indigo-400/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-20 w-80 h-80 bg-violet-400/20 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Glassmorphic Card Container -->
    <div class="max-w-md w-full bg-white/90 backdrop-blur-xl border border-slate-200/80 p-8 sm:p-10 rounded-3xl shadow-2xl shadow-indigo-100/60 relative z-10 transition-all">
        
        <!-- Header & Logo -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-gradient-to-tr from-indigo-600 to-violet-600 rounded-2xl flex items-center justify-center text-white mx-auto shadow-lg shadow-indigo-200 mb-4">
                <i class="fas fa-user-lock text-2xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Portal Single Sign-On</h1>
            <p class="text-xs text-slate-500 mt-1 font-medium">Sistem Informasi Mentoring Universitas Muhammadiyah Purwokerto</p>
        </div>

        <!-- Alerts -->
        @if ($errors->has('nim'))
            <div class="mb-6 p-3.5 rounded-2xl bg-rose-50 border border-rose-200/80 flex items-start space-x-3 text-rose-700 text-xs font-medium">
                <i class="fas fa-exclamation-circle text-sm mt-0.5 text-rose-500 shrink-0"></i>
                <span>{{ $errors->first('nim') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200/80 flex items-start space-x-3 text-emerald-700 text-xs font-medium">
                <i class="fas fa-check-circle text-sm mt-0.5 text-emerald-500 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <!-- NIM Input -->
            <div>
                <label for="nim" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIM / NIK / NIP SIA</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-id-card text-sm"></i>
                    </div>
                    <input
                        type="text"
                        id="nim"
                        name="nim"
                        required
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                        placeholder="Contoh: 2103040600"
                        value="{{ old('nim') }}">
                </div>
            </div>

            <!-- Password Input -->
            <div x-data="{ show: false }">
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-lock text-sm"></i>
                    </div>
                    <input
                        :type="show ? 'text' : 'password'"
                        id="password"
                        name="password"
                        required
                        class="w-full pl-10 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                        placeholder="Masukkan Kata Sandi">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full py-3.5 px-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all transform active:scale-[0.99] flex items-center justify-center space-x-2">
                <span>Masuk Sekarang</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </button>
        </form>

        <!-- Footer Notice -->
        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400 font-medium">Lupa kata sandi? Hubungi Biro Kemahasiswaan / LPPI UMP</p>
        </div>
    </div>
</div>
@endsection
