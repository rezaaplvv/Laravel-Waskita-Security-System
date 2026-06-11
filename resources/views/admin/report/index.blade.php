@extends('layouts.app')

@section('title', 'Data Laporan Lapangan')
@section('header', 'Monitoring Laporan Lapangan')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
        
        <div class="p-6 md:p-8 border-b border-gray-50 space-y-4 md:space-y-0 md:flex md:items-center md:justify-between bg-white">
            <div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Log Aktivitas & Insiden</h3>
                <p class="text-xs text-gray-500 font-medium mt-1">Pantau seluruh laporan kondisi lapangan dari semua titik penjagaan secara real-time.</p>
            </div>
            
            <form action="{{ route('admin.report.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                
                <div class="relative w-full sm:w-auto">
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl py-2.5 px-4 focus:ring-amber-400 focus:border-amber-400 font-medium transition-all cursor-pointer">
                </div>

                <select name="tipe" onchange="this.form.submit()" class="w-full sm:w-auto bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl py-2.5 pl-4 pr-8 focus:ring-amber-400 focus:border-amber-400 font-medium transition-all cursor-pointer">
                    <option value="" {{ request('tipe') == '' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="patroli" {{ request('tipe') == 'patroli' ? 'selected' : '' }}>Patroli Rutin</option>
                    <option value="insiden" {{ request('tipe') == 'insiden' ? 'selected' : '' }}>Insiden / Darurat</option>
                </select>
                
                <button type="submit" class="hidden"></button>
            </form>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-5">Waktu & Tipe</th>
                        <th class="px-8 py-5">Pelapor & Lokasi</th>
                        <th class="px-8 py-5">Deskripsi Kejadian</th>
                        <th class="px-8 py-5 text-right">Lampiran & GPS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    
                    @forelse($reports as $report)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        
                        <td class="px-8 py-4 align-top w-48">
                            <p class="font-black text-gray-900">{{ $report->created_at->format('d M Y') }}</p>
                            <p class="text-xs font-bold text-gray-400 mb-3">{{ $report->created_at->format('H:i') }} WIB</p>
                            
                            @if($report->tipe_laporan == 'insiden')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider bg-red-50 text-red-700 border border-red-200 shadow-sm">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                                    </span>
                                    Insiden
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Patroli
                                </span>
                            @endif
                        </td>

                        <td class="px-8 py-4 align-top w-72">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center font-black text-sm shrink-0">
                                    {{ strtoupper(substr($report->personel->nama_lengkap ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $report->personel->nama_lengkap ?? 'Personel Dihapus' }}</p>
                                    <p class="text-[11px] font-bold text-gray-400 mb-2">NIP: {{ $report->personel->nip ?? '-' }}</p>
                                    
                                    <div class="bg-gray-100 px-3 py-2 rounded-xl border border-gray-200 inline-block">
                                        <p class="text-xs font-black text-gray-800">{{ $report->client->nama_perusahaan ?? 'Lokasi Dihapus' }}</p>
                                        <p class="text-[10px] font-medium text-gray-500 mt-0.5 truncate max-w-[200px]" title="{{ $report->client->lokasi_penjagaan ?? '-' }}">
                                            {{ $report->client->lokasi_penjagaan ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-4 text-gray-700 align-top">
                            <p class="text-sm font-medium leading-relaxed max-w-md whitespace-normal line-clamp-3" title="{{ $report->deskripsi }}">
                                "{{ $report->deskripsi }}"
                            </p>
                        </td>

                        <td class="px-8 py-4 text-right align-top">
                            <div class="flex flex-col items-end gap-2">
                                
                                @if($report->foto_kejadian)
                                    <a href="{{ asset('storage/' . $report->foto_kejadian) }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm hover:shadow group w-28">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-blue-500 group-hover:scale-110 transition-transform">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                        Foto
                                    </a>
                                @endif

                                @if($report->koordinat_gps)
                                    <a href="https://www.google.com/maps?q={{ $report->koordinat_gps }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm hover:shadow group w-28">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-emerald-500 group-hover:scale-110 transition-transform">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        Peta GPS
                                    </a>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </div>
                                <h4 class="text-base font-black text-gray-900 mb-1">Belum Ada Laporan</h4>
                                <p class="text-sm font-medium text-gray-500">Saat ini belum ada data laporan lapangan yang masuk dari titik penjagaan.</p>
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