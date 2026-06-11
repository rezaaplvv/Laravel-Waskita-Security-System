@extends('layouts.app')

@section('title', 'Rekapitulasi Absensi')
@section('header', 'Data Absensi Personel')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
        
        <div class="p-6 md:p-8 border-b border-gray-50 space-y-4 md:space-y-0 md:flex md:items-center md:justify-between bg-white">
            <div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Log Kehadiran Personel</h3>
                <p class="text-xs text-gray-500 font-medium mt-1">Pantau waktu masuk, jam pulang, serta validasi lokasi dan foto selfie.</p>
            </div>
            
            <form action="{{ route('admin.attendance.index') }}" method="GET" class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative w-full sm:w-auto">
                    <input type="date" name="tanggal" value="{{ request('tanggal', \Carbon\Carbon::today()->toDateString()) }}" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl py-2.5 px-4 focus:ring-amber-400 focus:border-amber-400 font-medium transition-all cursor-pointer shadow-sm">
                </div>
                <button type="submit" class="hidden"></button>
            </form>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-5">Tanggal & Personel</th>
                        <th class="px-8 py-5">Absen Masuk</th>
                        <th class="px-8 py-5 text-center">Titik GPS Masuk</th>
                        <th class="px-8 py-5">Absen Pulang</th>
                        <th class="px-8 py-5 text-center">Titik GPS Pulang</th>
                        <th class="px-8 py-5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    
                    @forelse($attendances as $absen)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        
                        <td class="px-8 py-4 align-middle">
                            <p class="text-sm font-black text-gray-900">{{ $absen->personel->nama_lengkap }}</p>
                            <p class="text-xs font-bold text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d F Y') }}</p>
                        </td>
                        
                        <td class="px-8 py-4 align-middle">
                            <div class="flex items-center gap-4">
                                @if($absen->foto_masuk)
                                    <div class="relative w-14 h-14 shrink-0 cursor-pointer group/photo" onclick="showImageModal('{{ asset('storage/' . $absen->foto_masuk) }}')">
                                        <img src="{{ asset('storage/' . $absen->foto_masuk) }}" class="w-full h-full object-cover rounded-xl border border-gray-200 shadow-sm group-hover/photo:ring-2 group-hover/photo:ring-amber-400 transition-all" alt="Selfie Masuk">
                                        <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover/photo:opacity-100 flex items-center justify-center transition-opacity">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-14 h-14 shrink-0 rounded-xl bg-gray-100 border border-gray-200 border-dashed flex items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-black text-gray-900">{{ $absen->jam_masuk ?? '--:--' }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium">Waktu Masuk</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-4 text-center align-middle">
                            @if($absen->koordinat_masuk)
                                <a href="https://maps.google.com/?q={{ $absen->koordinat_masuk }}" target="_blank" class="inline-flex items-center gap-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-3 py-1.5 rounded-lg text-[10px] font-black transition-all shadow-sm hover:shadow group/btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-blue-500 group-hover/btn:scale-110 transition-transform">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    LOKASI MAPS
                                </a>
                            @else
                                <span class="text-[10px] text-gray-400 font-medium italic border border-transparent py-1.5 px-3 block">-</span>
                            @endif
                        </td>

                        <td class="px-8 py-4 align-middle">
                            <div class="flex items-center gap-4">
                                @if($absen->foto_pulang)
                                    <div class="relative w-14 h-14 shrink-0 cursor-pointer group/photo" onclick="showImageModal('{{ asset('storage/' . $absen->foto_pulang) }}')">
                                        <img src="{{ asset('storage/' . $absen->foto_pulang) }}" class="w-full h-full object-cover rounded-xl border border-gray-200 shadow-sm group-hover/photo:ring-2 group-hover/photo:ring-amber-400 transition-all" alt="Selfie Pulang">
                                        <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover/photo:opacity-100 flex items-center justify-center transition-opacity">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-14 h-14 shrink-0 rounded-xl bg-gray-50 border border-gray-200 border-dashed flex items-center justify-center text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-black text-gray-900">{{ $absen->jam_pulang ?? '--:--' }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium">Waktu Pulang</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-4 text-center align-middle">
                            @if($absen->koordinat_pulang)
                                <a href="https://maps.google.com/?q={{ $absen->koordinat_pulang }}" target="_blank" class="inline-flex items-center gap-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-3 py-1.5 rounded-lg text-[10px] font-black transition-all shadow-sm hover:shadow group/btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-blue-500 group-hover/btn:scale-110 transition-transform">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    LOKASI MAPS
                                </a>
                            @else
                                <span class="text-[10px] text-gray-400 font-medium italic border border-transparent py-1.5 px-3 block">-</span>
                            @endif
                        </td>

                        <td class="px-8 py-4 text-center align-middle">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $absen->status }}
                            </span>
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                    </svg>
                                </div>
                                <h4 class="text-base font-black text-gray-900 mb-1">Belum Ada Absensi</h4>
                                <p class="text-sm font-medium text-gray-500">Belum ada personel yang melakukan absensi pada tanggal ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="imageModal" class="fixed inset-0 z-50 hidden bg-gray-900/90 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300 opacity-0" onclick="closeImageModal()">
    <div class="relative max-w-2xl w-full mx-auto flex flex-col items-center" onclick="event.stopPropagation()">
        
        <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-gray-400 hover:text-white transition-colors bg-gray-800/50 hover:bg-gray-800 rounded-full p-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <img id="modalImgSrc" src="" class="w-auto h-auto max-h-[80vh] rounded-2xl shadow-2xl border-4 border-white/10 object-contain transform scale-95 transition-transform duration-300">
        
        <p class="text-white font-medium text-sm mt-4 bg-gray-800/50 px-4 py-2 rounded-lg border border-white/10">Preview Bukti Kehadiran</p>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImgSrc');

    function showImageModal(imageSrc) {
        modalImg.src = imageSrc;
        modal.classList.remove('hidden');
        
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalImg.classList.remove('scale-95');
            modalImg.classList.add('scale-100');
        }, 10);
    }

    function closeImageModal() {
        modal.classList.add('opacity-0');
        modalImg.classList.remove('scale-100');
        modalImg.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modalImg.src = '';
        }, 300);
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape" && !modal.classList.contains('hidden')) {
            closeImageModal();
        }
    });
</script>
@endpush