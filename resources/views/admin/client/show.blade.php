@extends('layouts.app')

@section('title', 'Kelola Lokasi Penjagaan')
@section('header', 'Detail & Plotting Personel')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.client.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-amber-500 transition-colors group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition-transform">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
            </svg>
            Kembali ke Daftar Mitra
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-50 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-gray-900 text-amber-400 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Perusahaan Mitra</h3>
                    <h2 class="text-2xl font-black text-gray-900 leading-tight">{{ $client->nama_perusahaan }}</h2>

                    <div class="mt-8 space-y-6">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Sektor Penjagaan</p>
                            <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-wider border border-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                {{ $client->lokasi_penjagaan }}
                            </span>
                        </div>

                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Alamat Lengkap</p>
                            <p class="text-sm font-medium text-gray-700 leading-relaxed">{{ $client->alamat_lengkap }}</p>
                        </div>
                    </div>

                    <div class="mt-8 bg-gray-50 rounded-2xl p-5 border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Personel Aktif</p>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-black text-gray-900">{{ $client->personels->count() }}</span>
                                <span class="text-xs font-bold text-gray-500 uppercase">Orang</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-amber-500"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Plotting Personel Baru</h3>
                </div>
                
                <form action="{{ route('admin.client.assign', $client->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="flex-1">
                        <select name="personel_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm font-medium rounded-xl py-3.5 px-4 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all cursor-pointer">
                            <option value="">-- Pilih Personel yang Sedang Standby --</option>
                            @foreach($availablePersonels as $avail)
                                <option value="{{ $avail->id }}">{{ $avail->nip }} - {{ $avail->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @if($availablePersonels->isEmpty())
                            <p class="text-[10px] font-bold text-red-500 mt-2 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" /></svg>
                                Seluruh personel telah di-ploting. Tidak ada personel standby.
                            </p>
                        @endif
                    </div>
                    <button type="submit" class="bg-amber-400 hover:bg-amber-300 text-gray-900 px-6 py-3.5 rounded-xl font-black text-sm uppercase tracking-wider transition-all shadow-lg shadow-amber-400/30 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 whitespace-nowrap" {{ $availablePersonels->isEmpty() ? 'disabled' : '' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tugaskan
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-50 bg-white flex items-center justify-between">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Daftar Regu Jaga</h3>
                    <span class="bg-emerald-50 text-emerald-700 text-[10px] font-black px-2 py-1 rounded uppercase border border-emerald-200">Aktif</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <tbody class="divide-y divide-gray-50">
                            @forelse($client->personels as $p)
                                <tr class="hover:bg-gray-50/80 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center font-black text-sm shrink-0">
                                                {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-900">{{ $p->nama_lengkap }}</p>
                                                <p class="text-[10px] font-bold text-gray-400">NIP: {{ $p->nip }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.client.remove_personel', ['id' => $client->id, 'personel_id' => $p->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menarik personel ini menjadi Standby?');">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 text-red-600 hover:text-white bg-red-50 hover:bg-red-600 border border-red-100 hover:border-red-600 px-4 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                                </svg>
                                                Tarik Tugas
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-sm font-black text-gray-900 mb-1">Belum Ada Regu Jaga</h4>
                                            <p class="text-xs font-medium text-gray-500">Silakan ploting personel melalui form di atas.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection