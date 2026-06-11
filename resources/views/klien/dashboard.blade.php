@extends('layouts.app')

@section('title', 'Portal Keamanan Klien')
@section('header', 'Pusat Pantauan Aset')

@section('content')
<div class="space-y-6">

    @if(isset($error))
        <div class="bg-red-50 text-red-600 p-6 rounded-2xl border border-red-100 shadow-sm font-bold">
            {{ $error }}
        </div>
    @else

        <div class="bg-gray-900 rounded-[2rem] p-8 md:p-10 text-white relative overflow-hidden shadow-lg border border-gray-800">
            <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <p class="text-amber-400 font-bold uppercase tracking-widest text-xs mb-2">Portal Transparansi Keamanan</p>
                    <h2 class="text-3xl font-black mb-2">Selamat Datang, {{ $client->nama_perusahaan }}</h2>
                    <p class="text-gray-400 text-sm">Pantau aktivitas pengamanan aset Anda secara real-time.</p>
                </div>
                <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 p-4 rounded-2xl text-left min-w-[200px]">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Lokasi Pengamanan</p>
                    <p class="font-bold text-white truncate">{{ $client->lokasi_penjagaan }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Total Personel Aktif</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ $totalPersonel }} <span class="text-sm font-bold text-gray-500">Orang</span></h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
                <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Laporan Hari Ini</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ $laporanHariIni }} <span class="text-sm font-bold text-gray-500">Laporan</span></h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
                <div class="w-14 h-14 {{ $insidenHariIni > 0 ? 'bg-red-50 text-red-500' : 'bg-emerald-50 text-emerald-500' }} rounded-2xl flex items-center justify-center">
                    @if($insidenHariIni > 0)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-7 h-7 animate-pulse"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @endif
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Status Keamanan</p>
                    <h3 class="text-xl font-black {{ $statusColor }}">{{ $statusArea }}</h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Live Feed Laporan Terkini
                    </h3>
                    <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">Lihat Semua &rarr;</a>
                </div>
                
                <div class="p-6">
                    @forelse($laporanTerkini as $laporan)
                        <div class="flex gap-4 mb-6 relative group">
                            @if(!$loop->last)
                                <div class="absolute top-10 bottom-[-24px] left-5 w-0.5 bg-gray-100"></div>
                            @endif
                            
                            <div class="relative z-10 shrink-0">
                                @if($laporan->personel->user->foto_profil ?? false)
                                    <img src="{{ asset('storage/' . $laporan->personel->user->foto_profil) }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm ring-2 ring-gray-50">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-gray-50">
                                        {{ substr($laporan->personel->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 bg-gray-50 rounded-2xl p-4 border border-gray-100 group-hover:bg-white group-hover:shadow-md transition-all">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm">{{ $laporan->personel->nama_lengkap }}</p>
                                        <p class="text-[10px] text-gray-500 font-semibold uppercase tracking-wider">{{ $laporan->created_at->diffForHumans() }} &bull; {{ $laporan->created_at->format('H:i') }} WIB</p>
                                    </div>
                                    @if($laporan->tipe_laporan == 'insiden')
                                        <span class="bg-red-100 text-red-700 text-[9px] font-black uppercase tracking-widest px-2 py-1 rounded-md border border-red-200 shadow-sm">⚠️ Insiden</span>
                                    @else
                                        <span class="bg-emerald-100 text-emerald-700 text-[9px] font-black uppercase tracking-widest px-2 py-1 rounded-md border border-emerald-200">✅ Patroli</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 leading-relaxed">{{ $laporan->deskripsi }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                            </div>
                            <p class="text-gray-400 font-bold text-sm">Belum ada aktivitas laporan masuk hari ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                        Tim Penjaga
                    </h3>
                </div>
                
                <div class="p-4 space-y-3">
                    @forelse($personelBertugas as $person)
                        <div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 border border-transparent hover:border-gray-100 transition">
                            @if($person->user->foto_profil ?? false)
                                <img src="{{ asset('storage/' . $person->user->foto_profil) }}" alt="{{ $person->nama_lengkap }}" class="w-12 h-12 rounded-[1rem] object-cover border border-gray-200 shadow-sm">
                            @else
                                <div class="w-12 h-12 rounded-[1rem] bg-gray-900 text-white flex items-center justify-center font-black text-lg shadow-sm border border-gray-800">
                                    {{ substr($person->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                            
                            <div>
                                <p class="font-bold text-sm text-gray-900">{{ $person->nama_lengkap }}</p>
                                <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mt-0.5">NIP: {{ $person->nip }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-gray-400 font-medium text-xs">Belum ada personel yang ditugaskan ke lokasi ini.</p>
                        </div>
                    @endforelse
                </div>
                <div class="p-4 border-t border-gray-50">
                    <a href="#" class="block w-full py-2.5 bg-gray-50 text-gray-600 text-xs font-bold uppercase tracking-widest text-center rounded-xl hover:bg-gray-100 hover:text-gray-900 transition">
                        Lihat Seluruh Tim
                    </a>
                </div>
            </div>

        </div>
    @endif
</div>
@endsection