@if(!request()->is('login'))
<footer class="bg-slate-900 text-slate-400 border-t border-slate-800 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <!-- Brand Column -->
            <div class="md:col-span-1 space-y-4">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                        <i class="fas fa-graduation-cap text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-white text-lg leading-tight tracking-tight">Mentoring <span class="text-indigo-400">UMP</span></span>
                        <span class="text-[10px] font-semibold text-slate-400 tracking-widest uppercase">Portal Akademik</span>
                    </div>
                </a>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Sistem informasi resmi pelaksanaan dan pemantauan kegiatan mentoring mahasiswa Universitas Muhammadiyah Purwokerto.
                </p>
                <div class="flex items-center space-x-3 pt-2">
                    <a href="https://ump.ac.id" target="_blank" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-indigo-600 text-slate-400 hover:text-white flex items-center justify-center text-xs transition-all">
                        <i class="fas fa-globe"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-indigo-600 text-slate-400 hover:text-white flex items-center justify-center text-xs transition-all">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-indigo-600 text-slate-400 hover:text-white flex items-center justify-center text-xs transition-all">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-white uppercase tracking-wider">Navigasi Utama</h4>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="/" class="hover:text-indigo-400 transition-colors">Beranda Utama</a></li>
                    <li><a href="/dashboard" class="hover:text-indigo-400 transition-colors">Dashboard Agenda</a></li>
                    <li><a href="{{ route('mycourse') }}" class="hover:text-indigo-400 transition-colors">Kelompok Mentoring Saya</a></li>
                    @if(Auth::check() && in_array(Auth::user()->role, ['mentor', 'petugas', 'pembimbing']))
                    <li><a href="{{ route('logbook.show') }}" class="hover:text-indigo-400 transition-colors">Logbook Kegiatan Sesi</a></li>
                    @endif
                </ul>
            </div>

            <!-- Campus Information -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-white uppercase tracking-wider">Kontak & Kampus</h4>
                <ul class="space-y-2 text-xs font-medium">
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-map-marker-alt text-indigo-400 mt-0.5 shrink-0"></i>
                        <span>Jl. KH. Ahmad Dahlan, Dukuhwaluh, Purwokerto</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-envelope text-indigo-400 shrink-0"></i>
                        <span>lppi@ump.ac.id</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-phone text-indigo-400 shrink-0"></i>
                        <span>(0281) 636751</span>
                    </li>
                </ul>
            </div>

            <!-- Program Info -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-white uppercase tracking-wider">LPPI UMP</h4>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Dikelola oleh Lembaga Pengkajian dan Pengamalan Islam (LPPI) Universitas Muhammadiyah Purwokerto.
                </p>
                <div class="pt-1">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                        <i class="fas fa-shield-alt mr-1.5"></i> Terverifikasi UMP
                    </span>
                </div>
            </div>

        </div>

        <div class="pt-8 mt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
            <p>© {{ date('Y') }} Universitas Muhammadiyah Purwokerto. Hak Cipta Dilindungi.</p>
            <div class="flex items-center space-x-4">
                <span class="hover:text-slate-400 transition-colors">Privasi & Ketentuan</span>
                <span>•</span>
                <span class="hover:text-slate-400 transition-colors">Bantuan Support</span>
            </div>
        </div>
    </div>
</footer>
@endif