@extends('layouts.app')

@section('title', 'Pusat Komando Supervisor')
@section('header', 'Pusat Komando')

@section('content')
<div class="space-y-6">

    <div class="bg-gray-900 rounded-[2rem] p-8 md:p-10 text-white relative overflow-hidden shadow-lg border border-gray-800">
        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -right-10 -bottom-10 w-40 h-40 border-[10px] border-amber-500/20 rounded-full"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <p class="text-amber-400 font-bold uppercase tracking-widest text-xs mb-2">Sistem Pemantauan Area</p>
                <h2 class="text-3xl font-black mb-2">Halo, Komandan {{ Auth::user()->name }}</h2>
                <p class="text-gray-400 text-sm">Berikut adalah ringkasan kedisiplinan dan keamanan area hari ini.</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Tanggal Operasional</p>
                <p class="font-bold text-white text-lg">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden">
            <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-500"></div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Sudah Absen Masuk</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $absenMasukHariIni }} <span class="text-sm font-bold text-gray-500">/ {{ $totalPersonel }} Orang</span></h3>
            </div>
            <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden">
            <div class="absolute bottom-0 left-0 w-full h-1 {{ $belumAbsen > 0 ? 'bg-amber-500' : 'bg-gray-200' }}"></div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Belum Absen (Mangkir)</p>
                <h3 class="text-3xl font-black {{ $belumAbsen > 0 ? 'text-amber-500' : 'text-gray-900' }}">{{ $belumAbsen }} <span class="text-sm font-bold text-gray-500">Orang</span></h3>
            </div>
            <div class="w-14 h-14 {{ $belumAbsen > 0 ? 'bg-amber-50 text-amber-500 animate-pulse' : 'bg-gray-50 text-gray-400' }} rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden">
            <div class="absolute bottom-0 left-0 w-full h-1 {{ count($insidenHariIni) > 0 ? 'bg-red-500' : 'bg-gray-200' }}"></div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Insiden Hari Ini</p>
                <h3 class="text-3xl font-black {{ count($insidenHariIni) > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ count($insidenHariIni) }} <span class="text-sm font-bold text-gray-500">Kejadian</span></h3>
            </div>
            <div class="w-14 h-14 {{ count($insidenHariIni) > 0 ? 'bg-red-50 text-red-600 animate-bounce' : 'bg-gray-50 text-gray-400' }} rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        
        <div class="bg-white rounded-[2rem] shadow-sm border {{ count($insidenHariIni) > 0 ? 'border-red-200' : 'border-gray-100' }} overflow-hidden">
            <div class="p-6 border-b {{ count($insidenHariIni) > 0 ? 'bg-red-50/50 border-red-100' : 'bg-gray-50/50 border-gray-100' }} flex justify-between items-center">
                <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full {{ count($insidenHariIni) > 0 ? 'bg-red-500 animate-pulse' : 'bg-gray-300' }}"></span>
                    S.O.S Insiden Terkini
                </h3>
                <a href="{{ route('supervisor.report.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">Lihat & Tindak Lanjut &rarr;</a>
            </div>
            <div class="p-4 space-y-4">
                @forelse($insidenHariIni as $insiden)
                    <div class="flex flex-col gap-3 p-4 rounded-2xl border border-red-100 bg-red-50/30">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-red-600 uppercase tracking-widest mb-0.5">{{ $insiden->client->nama_perusahaan ?? 'Area Publik' }}</p>
                                <p class="font-black text-gray-900">{{ $insiden->personel->nama_lengkap }}</p>
                            </div>
                            <span class="text-xs font-bold text-gray-500">{{ $insiden->created_at->format('H:i') }} WIB</span>
                        </div>
                        <p class="text-sm text-gray-700">{{ $insiden->deskripsi }}</p>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-emerald-600 font-bold text-sm">✅ Kondisi Aman. Tidak ada insiden yang dilaporkan hari ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full {{ count($personelMangkir) > 0 ? 'bg-amber-500 animate-pulse' : 'bg-gray-300' }}"></span>
                    Perhatian Kedisiplinan
                </h3>
                <a href="{{ route('supervisor.attendance.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">Cek Log Absensi &rarr;</a>
            </div>
            <div class="p-4 space-y-3">
                @forelse($personelMangkir as $person)
                    <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-gray-50 border border-transparent hover:border-gray-100 transition">
                        <div class="flex items-center gap-3">
                            @if($person->user && $person->user->foto_profil)
                                <img src="{{ asset('storage/' . $person->user->foto_profil) }}" class="w-10 h-10 rounded-[0.8rem] object-cover border border-gray-200">
                            @else
                                <div class="w-10 h-10 rounded-[0.8rem] bg-gray-900 text-white flex items-center justify-center font-black text-sm">
                                    {{ substr($person->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-sm text-gray-900">{{ $person->nama_lengkap }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Penempatan: {{ $person->client->nama_perusahaan ?? 'Belum Di-plot' }}</p>
                            </div>
                        </div>
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-black uppercase tracking-wider px-2 py-1 rounded">Belum Absen</span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-emerald-600 font-bold text-sm">✅ Disiplin Sempurna. Seluruh personel sudah absen masuk.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection