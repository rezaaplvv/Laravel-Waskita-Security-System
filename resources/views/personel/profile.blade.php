@extends('layouts.app')

@section('title', 'Profil Anggota')

@push('styles')
<style>
    @media (max-width: 768px) {
        aside, header { display: none !important; }
        main { padding: 0 !important; background-color: #f9fafb; }
    }
    .pb-safe { padding-bottom: 120px; }
</style>
@endpush

@section('content')
<div class="max-w-md mx-auto bg-gray-50 min-h-screen relative pb-safe shadow-2xl">

    <div class="bg-gray-900 px-6 pt-12 pb-28 rounded-b-[3rem] relative shadow-lg">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-black z-0"></div>
        <div class="absolute top-0 right-0 w-40 h-40 bg-amber-400/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 text-center">
            <h2 class="text-white text-xl font-black tracking-tight uppercase italic">ID Card Digital</h2>
            <p class="text-amber-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">PT Waskita Angkasa Satya</p>
        </div>
    </div>

    <div class="-mt-20 px-8 relative z-20">
        <div class="bg-white rounded-[2.5rem] p-8 shadow-2xl shadow-gray-300/60 border border-gray-100 flex flex-col items-center text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-amber-400 to-amber-200"></div>
            
            @if(Auth::user()->foto_profil)
                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" class="w-24 h-24 rounded-[2rem] object-cover border-4 border-gray-50 shadow-xl mb-4 animate-float">
            @else
                <div class="w-24 h-24 bg-gray-900 rounded-[2rem] flex items-center justify-center text-white text-3xl font-black shadow-xl border-4 border-gray-50 mb-4 animate-float">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif

            <h3 class="text-xl font-black text-gray-900 leading-tight">{{ Auth::user()->name }}</h3>
            <p class="text-amber-500 text-xs font-black uppercase tracking-widest mt-1">Personel Security</p>
            
            <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 rounded-full border border-emerald-100">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Status: Aktif</span>
            </div>

            <div class="mt-6 w-full py-3 bg-gray-50 rounded-2xl border border-gray-100">
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-[0.1em] mb-0.5">Nomor Induk Personel</p>
                <p class="text-lg font-black text-gray-900 tracking-tighter">{{ $personel->nip ?? 'W19001' }}</p>
            </div>
        </div>
    </div>

    <div class="px-6 mt-8 space-y-6">
        <div>
            <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-4 pl-2">Informasi Akun</h4>
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 space-y-5">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-400 font-bold uppercase mb-0.5">E-Mail Resmi</p>
                        <p class="text-sm font-bold text-gray-800">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-400 font-bold uppercase mb-0.5">Kontak Terdaftar</p>
                        <p class="text-sm font-bold text-gray-800">{{ $personel->no_hp ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-400 font-bold uppercase mb-0.5">Bergabung Sejak</p>
                        <p class="text-sm font-bold text-gray-800">{{ $personel->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-4 pl-2">Aksi Cepat</h4>
            <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-gray-100 divide-y divide-gray-50">
                <button class="w-full flex items-center justify-between p-5 hover:bg-gray-50 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700">Ganti Kata Sandi</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-gray-300 group-hover:translate-x-1 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </button>
                <button class="w-full flex items-center justify-between p-5 hover:bg-gray-50 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700">Hubungi Pusat / Admin</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-gray-300 group-hover:translate-x-1 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </button>
            </div>
        </div>

        <div class="pt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-5 rounded-[2rem] bg-red-50 text-red-600 font-black text-sm uppercase tracking-widest border border-red-100 hover:bg-red-100 transition active:scale-95">
                    Keluar Sistem
                </button>
            </form>
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
            <a href="{{ route('personel.history') }}" class="flex flex-col items-center justify-center w-16 h-14 text-gray-500 hover:text-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mb-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-[9px] font-bold uppercase tracking-wider">Riwayat</span>
            </a>
            <a href="{{ route('personel.profile') }}" class="flex flex-col items-center justify-center w-16 h-14 bg-gray-800/50 rounded-2xl text-amber-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mb-1">
                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" clip-rule="evenodd" />
                </svg>
                <span class="text-[9px] font-bold uppercase tracking-wider">Profil</span>
            </a>
        </div>
    </div>
</div>
@endsection