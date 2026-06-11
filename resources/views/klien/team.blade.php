@extends('layouts.app')

@section('title', 'Tim Penjaga')
@section('header', 'Personel Bertugas')

@section('content')
<div class="space-y-6">

    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between md:items-center gap-4 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-32 h-32 bg-amber-50 rounded-bl-[100px] -z-10"></div>
        
        <div>
            <h2 class="text-2xl font-black text-gray-900 mb-1">Daftar Personel Keamanan</h2>
            <p class="text-sm text-gray-500 font-medium">Berikut adalah tim satpam yang ditugaskan di lokasi <span class="text-gray-900 font-bold">{{ $client->lokasi_penjagaan }}</span>.</p>
        </div>
        
        <div class="bg-gray-900 text-white px-5 py-3 rounded-xl flex items-center gap-3 shadow-md shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-amber-400"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Total Tim</p>
                <p class="font-black text-lg leading-none">{{ $personelBertugas->count() }} Orang</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($personelBertugas as $person)
            @php
                // Cek status absensi hari ini
                $absenHariIni = $attendances->get($person->id);
                $isOnDuty = $absenHariIni && empty($absenHariIni->jam_pulang);
                $isShiftDone = $absenHariIni && !empty($absenHariIni->jam_pulang);
            @endphp

            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300 group relative">
                
                @if($isOnDuty)
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-emerald-500"></div>
                @elseif($isShiftDone)
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                @else
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-gray-200"></div>
                @endif

                <div class="p-6">
                    <div class="flex items-start gap-4 mb-5">
                        <div class="relative shrink-0">
                            @if($person->user->foto_profil ?? false)
                                <img src="{{ asset('storage/' . $person->user->foto_profil) }}" alt="{{ $person->nama_lengkap }}" class="w-16 h-16 rounded-[1.25rem] object-cover border border-gray-200 shadow-sm group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-16 h-16 rounded-[1.25rem] bg-gray-900 text-white flex items-center justify-center font-black text-2xl shadow-sm border border-gray-800 group-hover:scale-105 transition-transform">
                                    {{ substr($person->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                            
                            @if($isOnDuty)
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-4 border-white rounded-full animate-pulse"></div>
                            @endif
                        </div>
                        
                        <div>
                            <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1">NIP. {{ $person->nip }}</p>
                            <h3 class="font-black text-lg text-gray-900 leading-tight mb-1">{{ $person->nama_lengkap }}</h3>
                            <p class="text-xs font-semibold text-gray-500">{{ $person->no_hp ?? 'Tidak ada nomor HP' }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 flex justify-between items-center">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status Hari Ini</p>
                            @if($isOnDuty)
                                <span class="bg-emerald-100 text-emerald-700 text-xs font-black uppercase tracking-wider px-2.5 py-1 rounded-md">Sedang Bertugas</span>
                            @elseif($isShiftDone)
                                <span class="bg-blue-100 text-blue-700 text-xs font-black uppercase tracking-wider px-2.5 py-1 rounded-md">Shift Selesai</span>
                            @else
                                <span class="bg-gray-200 text-gray-600 text-xs font-black uppercase tracking-wider px-2.5 py-1 rounded-md">Belum Absen / Off</span>
                            @endif
                        </div>

                        @if($absenHariIni)
                            <div class="text-right">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Jam Masuk</p>
                                <p class="font-black text-gray-900 text-sm">{{ $absenHariIni->jam_masuk }} <span class="text-[10px]">WIB</span></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-10 rounded-[2rem] text-center border-2 border-dashed border-gray-200">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                </div>
                <h3 class="text-lg font-black text-gray-900 mb-1">Belum Ada Tim</h3>
                <p class="text-gray-500 font-medium text-sm">PT Waskita belum menugaskan personel keamanan ke lokasi Anda.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection