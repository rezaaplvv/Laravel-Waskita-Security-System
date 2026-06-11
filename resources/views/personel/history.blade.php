@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@push('styles')
<style>
    @media (max-width: 768px) {
        aside, header { display: none !important; }
        main { padding: 0 !important; background-color: #f9fafb; }
    }
    .pb-safe { padding-bottom: 100px; }
    
    /* Animasi Tab Transisi Halus */
    .tab-content { display: none; animation: fadeIn 0.4s ease-in-out forwards; }
    .tab-content.active { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div class="max-w-md mx-auto bg-gray-50 min-h-screen relative pb-safe shadow-2xl">

    <div class="bg-gray-900 px-6 pt-12 pb-6 rounded-b-[2.5rem] shadow-lg sticky top-0 z-30">
        <h2 class="text-white text-2xl font-black tracking-tight mb-4">Riwayat Aktivitas</h2>
        
        <div class="bg-gray-800 p-1 rounded-2xl flex relative w-full shadow-inner">
            <div id="tab-indicator" class="absolute top-1 bottom-1 left-1 w-[calc(50%-4px)] bg-amber-400 rounded-xl transition-all duration-300 shadow-md"></div>
            
            <button onclick="switchTab('kehadiran')" id="btn-kehadiran" class="relative z-10 flex-1 py-3 text-[11px] font-black uppercase tracking-widest text-gray-900 transition-colors">Log Kehadiran</button>
            <button onclick="switchTab('laporan')" id="btn-laporan" class="relative z-10 flex-1 py-3 text-[11px] font-black uppercase tracking-widest text-gray-400 transition-colors">Log Laporan</button>
        </div>
    </div>

    <div id="tab-kehadiran" class="tab-content active px-6 pt-6">
        <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-4 pl-1">30 Hari Terakhir</h3>
        <div class="space-y-4">
            
            @forelse($absensiList as $absen)
            <div class="bg-white rounded-[2rem] p-5 border border-gray-100 shadow-sm relative overflow-hidden flex flex-col gap-3">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $absen->jam_masuk && $absen->jam_pulang ? 'bg-emerald-400' : 'bg-amber-400' }}"></div>
                
                <div class="flex justify-between items-center pb-2 border-b border-gray-50">
                    <p class="text-sm font-black text-gray-900">{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('l, d M Y') }}</p>
                    @if($absen->jam_masuk && $absen->jam_pulang)
                        <span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Tuntas</span>
                    @else
                        <span class="bg-amber-50 text-amber-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider animate-pulse">Berjalan</span>
                    @endif
                </div>

                <div class="flex justify-between items-center px-2">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Jam Masuk</p>
                            <p class="text-base font-black text-gray-900">{{ $absen->jam_masuk ?? '--:--' }}</p>
                        </div>
                    </div>
                    
                    <div class="w-px h-8 bg-gray-200 mx-2"></div> <div class="flex items-center gap-3 justify-end text-right">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Jam Pulang</p>
                            <p class="text-base font-black text-gray-900">{{ $absen->jam_pulang ?? '--:--' }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-full {{ $absen->jam_pulang ? 'bg-amber-50 text-amber-500' : 'bg-gray-50 text-gray-300' }} flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" /></svg>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-gray-100 p-8 rounded-3xl text-center border-2 border-dashed border-gray-200">
                <p class="text-gray-400 font-bold text-sm">Belum ada riwayat kehadiran.</p>
            </div>
            @endforelse

        </div>
    </div>

    <div id="tab-laporan" class="tab-content px-6 pt-6">
        <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-4 pl-1">Aktivitas Laporan Anda</h3>
        <div class="space-y-4">
            
            @forelse($laporanList as $laporan)
            <div class="bg-white rounded-[2rem] p-5 border border-gray-100 shadow-sm flex flex-col gap-3 relative">
                <div class="flex justify-between items-start">
                    @if($laporan->tipe_laporan == 'insiden')
                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" /></svg>
                            Insiden
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            Patroli
                        </span>
                    @endif
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $laporan->created_at->format('d M Y') }}</p>
                        <p class="text-sm font-black text-gray-900">{{ $laporan->created_at->format('H:i') }} WIB</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                    <p class="text-sm text-gray-600 font-medium leading-relaxed">{{ Str::limit($laporan->deskripsi, 80) }}</p>
                    
                    @if($laporan->foto_kejadian)
                    <div class="mt-3 flex items-center gap-2 text-xs font-bold text-amber-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                        Melampirkan 1 Foto Bukti
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-gray-100 p-8 rounded-3xl text-center border-2 border-dashed border-gray-200">
                <p class="text-gray-400 font-bold text-sm">Belum ada aktivitas laporan dikirim.</p>
            </div>
            @endforelse

        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto z-40">
        <div class="bg-gray-900 mx-4 mb-4 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.3)] border border-gray-800 flex justify-around items-center p-2.5 backdrop-blur-xl bg-opacity-95">
            <a href="{{ route('personel.dashboard') }}" class="flex flex-col items-center justify-center w-16 h-14 text-gray-500 hover:text-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mb-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="text-[9px] font-bold uppercase tracking-wider">Beranda</span>
            </a>
            <a href="{{ route('personel.history') }}" class="flex flex-col items-center justify-center w-16 h-14 bg-gray-800/50 rounded-2xl text-amber-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mb-1">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                </svg>
                <span class="text-[9px] font-bold uppercase tracking-wider">Riwayat</span>
            </a>
            <a href="{{ route('personel.profile') }}" class="flex flex-col items-center justify-center w-16 h-14 text-gray-500 hover:text-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mb-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span class="text-[9px] font-bold uppercase tracking-wider">Profil</span>
            </a>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            const btnKehadiran = document.getElementById('btn-kehadiran');
            const btnLaporan = document.getElementById('btn-laporan');
            const indicator = document.getElementById('tab-indicator');
            const contentKehadiran = document.getElementById('tab-kehadiran');
            const contentLaporan = document.getElementById('tab-laporan');

            if (tabName === 'kehadiran') {
                // UI Animasi Pil
                indicator.style.transform = 'translateX(0%)';
                btnKehadiran.classList.add('text-gray-900');
                btnKehadiran.classList.remove('text-gray-400');
                btnLaporan.classList.add('text-gray-400');
                btnLaporan.classList.remove('text-gray-900');
                
                // Konten Switch
                contentLaporan.classList.remove('active');
                setTimeout(() => contentKehadiran.classList.add('active'), 50);

            } else if (tabName === 'laporan') {
                // UI Animasi Pil
                indicator.style.transform = 'translateX(100%)';
                btnLaporan.classList.add('text-gray-900');
                btnLaporan.classList.remove('text-gray-400');
                btnKehadiran.classList.add('text-gray-400');
                btnKehadiran.classList.remove('text-gray-900');
                
                // Konten Switch
                contentKehadiran.classList.remove('active');
                setTimeout(() => contentLaporan.classList.add('active'), 50);
            }
        }
    </script>
</div>
@endsection