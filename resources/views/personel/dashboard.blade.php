@extends('layouts.app')

@section('title', 'Waskita Guard - Mobile')

@push('styles')
<style>
    /* Menyembunyikan sidebar/navbar bawaan layouts.app khusus untuk tampilan HP */
    @media (max-width: 768px) {
        aside, header { display: none !important; }
        main { padding: 0 !important; background-color: #f9fafb; }
    }
    /* Memastikan konten tidak tertutup Bottom Navigation */
    .pb-safe { padding-bottom: 100px; }
</style>
@endpush

@section('content')

@if($activeBroadcast)
<!-- Modal Instruksi Komando (Full Screen) -->
<div id="instructionModal" class="fixed inset-0 bg-gray-950/90 backdrop-blur-md z-50 flex items-center justify-center p-6">
    <div class="bg-gray-900 border border-red-500/30 rounded-3xl p-8 w-full max-w-sm shadow-2xl relative">
        <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 w-20 h-20 bg-red-600 rounded-full flex items-center justify-center border-4 border-gray-900 shadow-lg animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="white" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        
        <div class="mt-10 text-center">
            <h2 class="text-red-500 font-black text-xl mb-1 uppercase tracking-widest">Intruksi Darurat</h2>
            <h3 class="text-white font-bold text-lg mb-4">{{ $activeBroadcast->judul }}</h3>
            
            <div class="bg-gray-800 rounded-xl p-4 text-gray-300 text-sm mb-8 border border-gray-700">
                {{ $activeBroadcast->isi_pesan }}
            </div>
            
            <button onclick="document.getElementById('instructionModal').remove()" class="w-full bg-amber-500 hover:bg-amber-400 text-gray-900 font-black text-sm py-4 rounded-xl shadow-lg shadow-amber-500/20 active:scale-95 transition-all uppercase tracking-wider flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" /></svg>
                SAYA DIMENGERTI & SIAP BERTUGAS
            </button>
        </div>
    </div>
</div>
@endif

<div class="max-w-md mx-auto bg-gray-50 min-h-screen relative pb-safe shadow-2xl">
    
    @if($personel && $personel->client_id)
        
        <div class="bg-gray-900 px-6 pt-12 pb-20 rounded-b-[2.5rem] relative overflow-hidden shadow-lg">
            <div class="absolute -top-20 -right-20 w-48 h-48 bg-amber-400/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Selamat Pagi,</p>
                    <h2 class="text-white text-2xl font-black tracking-tight">{{ Auth::user()->name }}</h2>
                    <p class="text-amber-400 text-xs font-bold mt-1">NIP: {{ $personel->nip ?? 'W19001' }}</p>
                </div>
                <div>
                    @if(Auth::user()->foto_profil)
                        <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" class="w-14 h-14 rounded-full object-cover border-2 border-white/20">
                    @else
                        <div class="w-14 h-14 rounded-full bg-amber-400 text-gray-900 flex items-center justify-center font-black text-xl border-2 border-white/20">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="-mt-10 px-6 relative z-20">
            <div class="bg-white rounded-3xl p-5 shadow-xl shadow-gray-200/60 border border-gray-100 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-50 rounded-2xl border border-gray-100 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Lokasi Tugas Aktif</p>
                        <p class="text-sm font-black text-gray-900 leading-tight">{{ $personel->client->nama_perusahaan }}</p>
                        <p class="text-xs font-medium text-gray-500">{{ $personel->client->lokasi_penjagaan }}</p>
                    </div>
                </div>
                
                @php
                    $isBekerja = !empty($absensi) && empty($absensi->jam_pulang);
                @endphp
                <div class="flex flex-col items-end">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider {{ $isBekerja ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $isBekerja ? 'bg-emerald-500 animate-pulse' : 'bg-gray-400' }}"></span>
                        {{ $isBekerja ? 'ON DUTY' : 'STANDBY' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="px-6 mt-6">
            @if(session('success'))
                <div class="bg-emerald-50 text-emerald-700 p-4 rounded-2xl mb-2 border border-emerald-100 text-sm font-bold flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 text-red-700 p-4 rounded-2xl mb-2 border border-red-100 text-sm font-bold flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" /></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 text-red-700 p-4 rounded-2xl mb-2 border border-red-100 text-sm font-bold flex flex-col gap-2">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="px-6 mt-6">
            <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 pl-1">Aksi Cepat</h4>
            <div class="grid grid-cols-2 gap-4">
                
                @if(empty($absensi))
                    <button type="button" onclick="openModal('modal-absen', 'Absen Masuk')" class="w-full bg-amber-400 hover:bg-amber-500 text-gray-900 rounded-[2rem] p-5 flex flex-col items-center justify-center shadow-xl shadow-amber-400/20 transition-transform transform active:scale-95 h-44 border border-amber-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 mb-3 opacity-80">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0119.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 004.5 10.5a7.464 7.464 0 01-1.15 3.993m1.989 3.559A11.209 11.209 0 008.25 10.5a3.75 3.75 0 117.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 01-3.6 9.75m6.633-4.596a18.666 18.666 0 01-2.485 5.33" />
                        </svg>
                        <span class="font-black text-lg leading-tight text-center">ABSEN<br>MASUK</span>
                        <span class="text-xs font-bold opacity-75 mt-1">{{ now()->format('H:i') }} WIB</span>
                    </button>
                @elseif(!empty($absensi) && empty($absensi->jam_pulang))
                    <button type="button" onclick="openModal('modal-absen', 'Absen Pulang')" class="w-full bg-white border border-emerald-200 text-emerald-600 hover:bg-emerald-50 rounded-[2rem] p-5 flex flex-col items-center justify-center shadow-xl shadow-emerald-500/10 transition-transform transform active:scale-95 h-44">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 mb-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-black text-lg leading-tight text-center">ABSEN<br>PULANG</span>
                        <span class="text-[10px] font-bold text-gray-500 mt-1 uppercase tracking-wider">Masuk: {{ $absensi->jam_masuk }}</span>
                    </button>
                @else
                    <div class="w-full bg-gray-100 text-gray-400 rounded-[2rem] p-5 flex flex-col items-center justify-center h-44 cursor-not-allowed border border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mb-3 opacity-50">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-black text-lg leading-tight text-center">SHIFT<br>SELESAI</span>
                    </div>
                @endif

                <a href="{{ route('personel.report.create') }}" class="w-full bg-gray-900 hover:bg-black text-white rounded-[2rem] p-5 flex flex-col items-center justify-center shadow-xl shadow-gray-900/30 transition-transform transform active:scale-95 h-44 border border-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 mb-3 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    <span class="font-black text-lg leading-tight text-center">BUAT<br>LAPORAN</span>
                </a>
            </div>
        </div>

        <div class="px-6 mt-8">
            <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-4 pl-1">Ringkasan Hari Ini</h4>
            <div class="bg-white rounded-[2rem] p-7 shadow-sm border border-gray-100 relative">
                <div class="relative pl-6 border-l-2 border-gray-100 space-y-8">
                    
                    <div class="relative">
                        <div class="absolute -left-[33px] top-1 w-4 h-4 rounded-full border-4 border-white {{ !empty($absensi) ? 'bg-emerald-500' : 'bg-gray-200' }} shadow-sm"></div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Absen Masuk</p>
                        <p class="text-xl font-black text-gray-900 leading-none mb-1">{{ $absensi->jam_masuk ?? '--:--' }} <span class="text-xs font-bold text-gray-500">WIB</span></p>
                        @if(!empty($absensi)) 
                            <p class="text-xs text-emerald-600 font-bold">✓ Masuk Berhasil</p> 
                        @else
                            <p class="text-xs text-gray-400 font-medium italic">Belum Absen</p>
                        @endif
                    </div>
                    
                    <div class="relative">
                        <div class="absolute -left-[33px] top-1 w-4 h-4 rounded-full border-4 border-white {{ (!empty($absensi) && !empty($absensi->jam_pulang)) ? 'bg-amber-500' : 'bg-gray-200' }} shadow-sm"></div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Absen Pulang</p>
                        <p class="text-xl font-black text-gray-900 leading-none mb-1">{{ $absensi->jam_pulang ?? '--:--' }} <span class="text-xs font-bold text-gray-500">WIB</span></p>
                        @if(!empty($absensi) && empty($absensi->jam_pulang)) 
                            <p class="text-xs text-amber-500 font-bold animate-pulse">Sedang Bertugas...</p> 
                        @elseif(!empty($absensi) && !empty($absensi->jam_pulang))
                            <p class="text-xs text-emerald-600 font-bold">✓ Shift Selesai</p>
                        @else
                            <p class="text-xs text-gray-400 font-medium italic">Belum Absen</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    @else
        <div class="bg-gray-900 px-6 pt-12 pb-32 rounded-b-[3rem] relative text-center">
            <div class="flex justify-center mb-4">
                @if(Auth::user()->foto_profil)
                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" class="w-16 h-16 rounded-full object-cover border-4 border-gray-800 shadow-lg relative z-10">
                @else
                    <div class="w-16 h-16 rounded-full bg-amber-400 text-gray-900 flex items-center justify-center font-black text-2xl border-4 border-gray-800 shadow-lg relative z-10">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <h2 class="text-white text-2xl font-black tracking-tight mb-2">Halo, {{ Auth::user()->name }}</h2>
            <p class="text-gray-400 text-sm font-medium">Personel Security</p>
        </div>

        <div class="-mt-20 px-6 relative z-20">
            <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-amber-400"></div>
                
                <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-white shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-amber-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <span class="inline-block px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-600 mb-4">
                    Status: Standby
                </span>

                <h3 class="text-xl font-black text-gray-900 mb-3">Menunggu Penempatan</h3>
                <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                    Akun Anda telah aktif, namun Pusat belum menetapkan lokasi tugas Anda. Mohon tunggu instruksi selanjutnya.
                </p>

                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 text-left">
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-3">Identitas Terdaftar:</p>
                    <div class="space-y-2">
                        <p class="text-sm font-bold text-gray-900"><span class="font-medium text-gray-500 w-12 inline-block">Nama</span> : {{ $personel->nama_lengkap ?? Auth::user()->name }}</p>
                        <p class="text-sm font-bold text-gray-900"><span class="font-medium text-gray-500 w-12 inline-block">NIP</span> : {{ $personel->nip ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto z-40">
        <div class="bg-gray-900 mx-4 mb-4 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.3)] border border-gray-800 flex justify-around items-center p-2.5 backdrop-blur-xl bg-opacity-95">
            <a href="{{ route('personel.dashboard') }}" class="flex flex-col items-center justify-center w-16 h-14 bg-gray-800/50 rounded-2xl text-amber-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mb-1">
                    <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                    <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                </svg>
                <span class="text-[9px] font-bold uppercase tracking-wider">Beranda</span>
            </a>
            <a href="{{ route('personel.history') }}" class="flex flex-col items-center justify-center w-16 h-14 text-gray-500 hover:text-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mb-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
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

    <div id="modal-absen" class="hidden fixed inset-0 bg-gray-900 bg-opacity-80 z-50 flex items-center justify-center px-4 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-sm p-8 transform transition-all relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-400/10 rounded-bl-[100px] -z-10"></div>
            
            <h3 id="modal-title" class="text-2xl font-black text-gray-900 mb-2 tracking-tight">Konfirmasi Absen</h3>
            <p class="text-sm text-gray-500 mb-6 font-medium leading-relaxed">Silakan ambil foto selfie di lokasi Anda bertugas saat ini sebagai bukti kehadiran operasional.</p>
            
            <form action="{{ route('personel.absen') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="koordinat_gps" id="koordinat_gps">
                
                <div id="gps-status" class="mb-4 w-full"></div>
                
                <div class="mb-5 border-2 border-dashed border-gray-300 rounded-3xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative group bg-gray-50/50">
                    <input type="file" name="foto" id="foto" accept="image/*" capture="user" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="text-blue-600 flex flex-col items-center pointer-events-none group-hover:scale-105 transition-transform">
                        <svg class="w-12 h-12 mb-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"></path>
                        </svg>
                        <span class="text-sm font-black text-gray-900 uppercase tracking-widest">Buka Kamera</span>
                        <span class="text-[10px] font-bold text-gray-400 mt-1 uppercase">Ambil Foto Selfie</span>
                    </div>
                </div>
                
                <img id="preview" class="hidden w-full h-48 object-cover rounded-2xl mb-6 border-4 border-gray-100 shadow-sm" src="" alt="Preview">

                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('modal-absen')" class="w-1/2 py-3.5 px-4 bg-gray-100 rounded-xl text-gray-600 font-bold hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="w-1/2 py-3.5 px-4 bg-gray-900 text-amber-400 rounded-xl font-bold hover:bg-black transition shadow-lg shadow-gray-900/20">Kirim Absen</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id, title) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            document.getElementById('modal-title').innerText = title;

            const gpsInput = document.getElementById('koordinat_gps');
            const gpsStatus = document.getElementById('gps-status');
            const submitBtn = modal.querySelector('button[type="submit"]');

            gpsStatus.classList.remove('hidden');
            gpsStatus.innerHTML = `
                <div class="flex items-center justify-center gap-2 text-amber-600 mb-4 bg-amber-50 p-3 rounded-xl border border-amber-100">
                    <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span class="text-xs font-bold">Mengunci Sinyal GPS...</span>
                </div>`;
            
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const coords = lat + "," + lng;
                        
                        if(gpsInput) gpsInput.value = coords;
                        
                        gpsStatus.innerHTML = `
                            <div class="bg-emerald-50 border border-emerald-100 p-3 rounded-xl text-emerald-700 text-center mb-4 shadow-sm">
                                <p class="font-black text-[10px] uppercase tracking-widest">📍 Koordinat Terkunci</p>
                                <p class="font-mono text-xs mt-1 font-bold">${coords}</p>
                            </div>`;
                        
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    },
                    function(error) {
                        gpsStatus.innerHTML = `<div class="bg-red-50 p-3 rounded-xl text-center mb-4 border border-red-100"><p class="text-red-600 font-bold text-xs">Akses lokasi (GPS) wajib diizinkan!</p></div>`;
                    },
                    { enableHighAccuracy: true }
                );
            } else {
                gpsStatus.innerHTML = `<p class="text-red-600 text-center font-bold text-xs mb-3">Perangkat tidak mendukung GPS.</p>`;
            }
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            
            document.getElementById('foto').value = '';
            const preview = document.getElementById('preview');
            preview.classList.add('hidden');
            preview.src = '';

            const gpsStatus = document.getElementById('gps-status');
            if(gpsStatus) gpsStatus.innerHTML = '';
            const gpsInput = document.getElementById('koordinat_gps');
            if(gpsInput) gpsInput.value = '';
        }

        document.getElementById('foto').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('preview');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });
    </script>
</div>
@endsection