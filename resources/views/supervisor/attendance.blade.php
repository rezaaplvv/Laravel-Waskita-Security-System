@extends('layouts.app')

@section('title', 'Validasi Kehadiran Personel')
@section('header', 'Validasi Kehadiran')

@section('content')
<div class="space-y-6">

    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between md:items-center gap-4 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-32 h-32 bg-gray-50 rounded-bl-[100px] -z-10"></div>
        <div>
            <h2 class="text-2xl font-black text-gray-900 mb-1">Konsol Pemantauan Presensi</h2>
            <p class="text-sm text-gray-500 font-medium">Validasi kecocokan titik koordinat GPS, jam kerja, dan dokumentasi foto masuk/pulang personel keamanan.</p>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h3 class="font-black text-gray-900 text-base">Seluruh Log Kehadiran Anggota</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-[10px] font-black text-gray-400 uppercase tracking-widest bg-gray-50/50">
                        <th class="py-4 px-6 text-center w-16">No</th>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Nama Anggota</th>
                        <th class="py-4 px-6">Lokasi Plotting</th>
                        <th class="py-4 px-6 text-center">Masuk</th>
                        <th class="py-4 px-6 text-center">Pulang</th>
                        <th class="py-4 px-6 text-center">GPS & Foto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($attendances as $index => $absen)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="py-4 px-6 text-center font-bold text-gray-400">
                                {{ $attendances->firstItem() + $index }}
                            </td>
                            
                            <td class="py-4 px-6 font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d M Y') }}
                            </td>
                            
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    @if($absen->personel->user->foto_profil ?? false)
                                        <img src="{{ asset('storage/' . $absen->personel->user->foto_profil) }}" class="w-8 h-8 rounded-lg object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-lg bg-gray-900 text-white flex items-center justify-center font-black text-xs">
                                            {{ substr($absen->personel->nama_lengkap, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-black text-gray-900 leading-tight">{{ $absen->personel->nama_lengkap }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase mt-0.5">NIP: {{ $absen->personel->nip }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6 font-semibold text-gray-700">
                                {{ $absen->personel->client->nama_perusahaan ?? 'Belum Ditugaskan' }}
                            </td>
                            
                            <td class="py-4 px-6 text-center font-mono font-bold text-emerald-600">
                                {{ $absen->jam_masuk ?? '--:--' }}
                            </td>
                            
                            <td class="py-4 px-6 text-center font-mono font-bold {{ $absen->jam_pulang ? 'text-amber-500' : 'text-gray-300' }}">
                                {{ $absen->jam_pulang ?? '--:--' }}
                            </td>
                            
                            <td class="py-4 px-6 text-center">
                                @if($absen->foto)
                                    <button type="button" 
                                            onclick="openValidationModal('{{ asset('storage/' . $absen->foto) }}', '{{ $absen->personel->nama_lengkap }}', '{{ $absen->koordinat_gps ?? 'Tidak terekam' }}')" 
                                            class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-gray-900 bg-amber-400 hover:bg-amber-500 px-3 py-2 rounded-xl transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                        Periksa
                                    </button>
                                @else
                                    <span class="text-xs font-bold text-gray-300 italic">Tanpa Bukti</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <p class="text-gray-400 font-bold">Belum ada data presensi masuk dari unit lapangan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($attendances->hasPages())
            <div class="p-6 border-t border-gray-100 bg-gray-50/50">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>
</div>

<div id="validation-modal" class="hidden fixed inset-0 bg-gray-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity duration-300" onclick="closeValidationModal()">
    <div class="bg-white rounded-[2rem] overflow-hidden shadow-2xl max-w-sm w-full p-6 relative border border-gray-100" onclick="event.stopPropagation()">
        
        <div class="flex justify-between items-center mb-4">
            <div>
                <h4 class="font-black text-gray-900 text-base">Verifikasi Autentikasi</h4>
                <p id="v-name" class="text-xs text-amber-500 font-bold uppercase tracking-wider mt-0.5"></p>
            </div>
            <button onclick="closeValidationModal()" class="w-8 h-8 bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-full flex items-center justify-center transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="mb-4 rounded-2xl overflow-hidden border bg-gray-50 shadow-inner">
            <img id="v-img" src="" alt="Bukti Presensi" class="w-full h-64 object-cover">
        </div>

        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Koordinat GPS Terkunci</p>
            <div class="flex items-center gap-2 text-xs font-mono font-bold text-gray-700">
                <svg class="w-4 h-4 text-emerald-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                <span id="v-gps"></span>
            </div>
        </div>

        <div class="mt-4">
            <a id="v-link-maps" href="#" target="_blank" class="block w-full py-3 bg-gray-900 hover:bg-black text-amber-400 text-xs font-black uppercase tracking-widest text-center rounded-xl transition shadow-md">
                Buka Di Google Maps
            </a>
        </div>
    </div>
</div>

<script>
    function openValidationModal(imgSrc, name, gpsCoords) {
        const modal = document.getElementById('validation-modal');
        document.getElementById('v-img').src = imgSrc;
        document.getElementById('v-name').innerText = 'Personel: ' + name;
        document.getElementById('v-gps').innerText = gpsCoords;
        
        // Buat tautan otomatis ke Google Maps berdasarkan koordinat GPS
        const mapsLink = document.getElementById('v-link-maps');
        if(gpsCoords && gpsCoords !== 'Tidak terekam') {
            mapsLink.href = 'https://www.google.com/maps/search/?api=1&query=' + gpsCoords;
            mapsLink.style.display = 'block';
        } else {
            mapsLink.style.display = 'none';
        }

        modal.classList.remove('hidden');
    }

    function closeValidationModal() {
        document.getElementById('validation-modal').classList.add('hidden');
    }
</script>
@endsection