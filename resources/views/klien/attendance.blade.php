@extends('layouts.app')

@section('title', 'Log Kehadiran Personel')
@section('header', 'Pantauan Disiplin')

@section('content')
<div class="space-y-6">

    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between md:items-center gap-4 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-32 h-32 bg-gray-50 rounded-bl-[100px] -z-10"></div>
        <div>
            <h2 class="text-2xl font-black text-gray-900 mb-1">Riwayat Presensi & Absensi</h2>
            <p class="text-sm text-gray-500 font-medium">Rekapitulasi jam kerja, kedatangan, dan dokumentasi *selfie* personel di lokasi <span class="text-gray-900 font-bold">{{ $client->lokasi_penjagaan }}</span>.</p>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="font-black text-gray-900 text-base">Log Aktivitas Kehadiran</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-[10px] font-black text-gray-400 uppercase tracking-widest bg-gray-50/50">
                        <th class="py-4 px-6 text-center w-16">No</th>
                        <th class="py-4 px-6">Tanggal & Hari</th>
                        <th class="py-4 px-6">Nama Personel</th>
                        <th class="py-4 px-6 text-center">Jam Masuk</th>
                        <th class="py-4 px-6 text-center">Jam Pulang</th>
                        <th class="py-4 px-6 text-center">Dokumentasi</th>
                        <th class="py-4 px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($attendances as $index => $absen)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-gray-400">{{ $index + 1 }}</td>
                            
                            <td class="py-4 px-6 font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('l, d M Y') }}
                            </td>
                            
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gray-900 text-white flex items-center justify-center font-black text-xs">
                                        {{ substr($absen->personel->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-gray-900 leading-tight">{{ $absen->personel->nama_lengkap }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-0.5">NIP: {{ $absen->personel->nip }}</p>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="py-4 px-6 text-center font-mono font-bold text-emerald-600">
                                {{ $absen->jam_masuk ?? '--:--' }} <span class="text-[10px] text-gray-400">WIB</span>
                            </td>
                            
                            <td class="py-4 px-6 text-center font-mono font-bold {{ $absen->jam_pulang ? 'text-amber-500' : 'text-gray-300' }}">
                                {{ $absen->jam_pulang ?? '--:--' }} @if($absen->jam_pulang) <span class="text-[10px] text-gray-400">WIB</span> @endif
                            </td>
                            
                            <td class="py-4 px-6 text-center">
                                @if($absen->foto)
                                    <button type="button" onclick="viewPhoto('{{ asset('storage/' . $absen->foto) }}', '{{ $absen->personel->nama_lengkap }}')" class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-blue-600 hover:text-blue-800 bg-blue-50 px-3 py-1.5 rounded-xl transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                        Lihat Foto
                                    </button>
                                @else
                                    <span class="text-xs font-bold text-gray-300 italic">No Photo</span>
                                @endif
                            </td>
                            
                            <td class="py-4 px-6 text-center">
                                @if($absen->jam_masuk && !$absen->jam_pulang)
                                    <span class="inline-block px-2.5 py-1 bg-emerald-50 border border-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-wider rounded-md animate-pulse">Bertugas</span>
                                @else
                                    <span class="inline-block px-2.5 py-1 bg-gray-100 border border-gray-200 text-gray-600 text-[10px] font-black uppercase tracking-wider rounded-md">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                </div>
                                <p class="text-gray-400 font-bold">Belum ada riwayat presensi personel untuk lokasi Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="photo-modal" class="hidden fixed inset-0 bg-gray-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity duration-300" onclick="closePhoto()">
    <div class="bg-white rounded-[2rem] overflow-hidden shadow-2xl max-w-sm w-full p-6 relative border border-gray-100" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h4 class="font-black text-gray-900 text-base">Bukti Selfie Kehadiran</h4>
                <p id="modal-personel-name" class="text-xs text-amber-500 font-bold uppercase tracking-wider mt-0.5"></p>
            </div>
            <button onclick="closePhoto()" class="w-8 h-8 bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-full flex items-center justify-center transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <img id="modal-img" src="" alt="Bukti Absensi" class="w-full h-72 object-cover rounded-2xl border shadow-inner">
    </div>
</div>

<script>
    function viewPhoto(src, name) {
        const modal = document.getElementById('photo-modal');
        document.getElementById('modal-img').src = src;
        document.getElementById('modal-personel-name').innerText = 'Personel: ' + name;
        modal.classList.remove('hidden');
    }

    function closePhoto() {
        document.getElementById('photo-modal').add('hidden');
    }
</script>
@endsection