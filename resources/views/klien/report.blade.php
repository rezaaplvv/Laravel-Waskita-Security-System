@extends('layouts.app')

@section('title', 'Laporan Keamanan Lapangan')
@section('header', 'Riwayat Laporan')

@section('content')
<div class="space-y-6">

    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col lg:flex-row justify-between lg:items-center gap-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-32 h-32 bg-amber-50 rounded-bl-[100px] -z-10"></div>
        
        <div>
            <h2 class="text-2xl font-black text-gray-900 mb-1">Laporan Operasional Lapangan</h2>
            <p class="text-sm text-gray-500 font-medium">Arsip laporan patroli rutin dan insiden di area <span class="text-gray-900 font-bold">{{ $client->lokasi_penjagaan }}</span>.</p>
        </div>

        <div class="flex p-1 bg-gray-50 rounded-xl border border-gray-200 shadow-inner">
            <a href="{{ route('klien.report') }}" class="px-4 py-2 text-xs font-bold uppercase tracking-widest rounded-lg transition {{ !request('tipe') ? 'bg-white text-gray-900 shadow-sm border border-gray-200' : 'text-gray-400 hover:text-gray-600' }}">
                Semua
            </a>
            <a href="{{ route('klien.report', ['tipe' => 'patroli']) }}" class="px-4 py-2 text-xs font-bold uppercase tracking-widest rounded-lg transition {{ request('tipe') == 'patroli' ? 'bg-emerald-50 text-emerald-700 shadow-sm border border-emerald-100' : 'text-gray-400 hover:text-gray-600' }}">
                Patroli
            </a>
            <a href="{{ route('klien.report', ['tipe' => 'insiden']) }}" class="px-4 py-2 text-xs font-bold uppercase tracking-widest rounded-lg transition {{ request('tipe') == 'insiden' ? 'bg-red-50 text-red-700 shadow-sm border border-red-100' : 'text-gray-400 hover:text-gray-600' }}">
                Insiden
            </a>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($reports as $report)
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row gap-6 hover:shadow-md transition">
                
                <div class="md:w-48 shrink-0 flex flex-col md:border-r border-gray-100 md:pr-6">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('l, d M Y') }}</p>
                    <p class="text-2xl font-black text-gray-900 leading-none mb-3">{{ \Carbon\Carbon::parse($report->created_at)->format('H:i') }} <span class="text-xs font-bold text-gray-400">WIB</span></p>
                    
                    @if($report->tipe_laporan == 'insiden')
                        <div class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-red-100 w-max">
                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" /></svg>
                            Insiden
                        </div>
                    @else
                        <div class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-emerald-100 w-max">
                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            Patroli Rutin
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        @if($report->personel->user->foto_profil ?? false)
                            <img src="{{ asset('storage/' . $report->personel->user->foto_profil) }}" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                        @else
                            <div class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center font-bold text-xs">
                                {{ substr($report->personel->nama_lengkap, 0, 1) }}
                            </div>
                        @endif
                        <p class="font-bold text-gray-900 text-sm">Dilaporkan oleh: <span class="text-amber-600">{{ $report->personel->nama_lengkap }}</span></p>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 mb-4">
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $report->deskripsi }}</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center gap-2 text-xs font-mono font-bold text-gray-500 bg-white border border-gray-200 px-3 py-2 rounded-xl">
                            <svg class="w-4 h-4 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            {{ $report->koordinat_gps ?? 'Koordinat tidak direkam' }}
                        </div>
                        
                        @if($report->foto_kejadian)
                            <button type="button" onclick="viewPhoto('{{ asset('storage/' . $report->foto_kejadian) }}')" class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-blue-600 bg-blue-50 border border-blue-100 px-4 py-2 rounded-xl hover:bg-blue-100 transition">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                Bukti Foto Lampiran
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-12 rounded-[2rem] text-center border-2 border-dashed border-gray-200">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                </div>
                <h3 class="text-lg font-black text-gray-900 mb-1">Tidak Ada Laporan</h3>
                <p class="text-gray-500 font-medium text-sm">Belum ada catatan aktivitas lapangan berdasarkan filter yang Anda pilih.</p>
            </div>
        @endforelse
    </div>
</div>

<div id="photo-modal" class="hidden fixed inset-0 bg-gray-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity duration-300" onclick="closePhoto()">
    <div class="bg-white rounded-[2rem] overflow-hidden shadow-2xl max-w-lg w-full p-6 relative border border-gray-100" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h4 class="font-black text-gray-900 text-lg">Bukti Foto Lapangan</h4>
            <button onclick="closePhoto()" class="w-8 h-8 bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-full flex items-center justify-center transition">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <img id="modal-img" src="" alt="Bukti Lapangan" class="w-full max-h-[70vh] object-contain rounded-2xl border bg-gray-50">
    </div>
</div>

<script>
    function viewPhoto(src) {
        const modal = document.getElementById('photo-modal');
        document.getElementById('modal-img').src = src;
        modal.classList.remove('hidden');
    }

    function closePhoto() {
        document.getElementById('photo-modal').add('hidden');
    }
</script>
@endsection