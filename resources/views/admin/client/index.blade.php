@extends('layouts.app')

@section('title', 'Data Klien & Lokasi')
@section('header', 'Manajemen Mitra Klien')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
        
        <div class="p-6 md:p-8 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white">
            <div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Daftar Klien & Area Penjagaan</h3>
                <p class="text-xs text-gray-500 font-medium mt-1">Kelola data perusahaan mitra dan atur penempatan personel operasional.</p>
            </div>
            
            <div class="flex items-center">
                <a href="{{ route('admin.client.create') }}" class="flex items-center justify-center gap-2 bg-amber-400 hover:bg-amber-300 text-gray-900 px-6 py-3 rounded-xl font-black text-sm uppercase tracking-wider transition-all shadow-lg shadow-amber-400/30 transform hover:-translate-y-0.5 w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Klien
                </a>
            </div>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-5">Nama Perusahaan</th>
                        <th class="px-8 py-5">Sektor / Lokasi Penjagaan</th>
                        <th class="px-8 py-5">Alamat Lengkap</th>
                        <th class="px-8 py-5 text-center">Plotting Personel</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    
                    @forelse($clients as $client)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        
                        <td class="px-8 py-5 align-middle">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-400 shadow-sm group-hover:bg-amber-50 group-hover:text-amber-500 group-hover:border-amber-200 transition-colors shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-gray-900">{{ $client->nama_perusahaan }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-1">Mitra Resmi</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-5 align-middle">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                {{ $client->lokasi_penjagaan }}
                            </span>
                        </td>

                        <td class="px-8 py-5 align-middle w-64">
                            <p class="text-xs text-gray-600 font-medium whitespace-normal line-clamp-2 leading-relaxed" title="{{ $client->alamat_lengkap }}">
                                {{ $client->alamat_lengkap }}
                            </p>
                        </td>

                        <td class="px-8 py-5 text-center align-middle">
                            <a href="{{ route('admin.client.show', $client->id) }}" class="inline-flex items-center gap-2 bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-md transform hover:-translate-y-0.5 group/btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-400 group-hover/btn:text-white transition-colors">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                Kelola Personel
                            </a>
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                    </svg>
                                </div>
                                <h4 class="text-base font-black text-gray-900 mb-1">Data Mitra Kosong</h4>
                                <p class="text-sm font-medium text-gray-500">Belum ada data perusahaan klien dan lokasi penjagaan yang terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection