@extends('layouts.app')

@section('title', 'Admin Control Center')
@section('header', 'Pusat Kendali Operasional')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style> 
    #map { z-index: 10; border-radius: 1.5rem; } 
    /* Kustomisasi scrollbar untuk Timeline */
    .timeline-scroll::-webkit-scrollbar { width: 4px; }
    .timeline-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
    .timeline-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
</style>
@endpush

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div>
            <h2 class="text-2xl font-black text-gray-900">Dashboard Interaktif</h2>
            <p class="text-sm text-gray-500 font-medium">Monitoring Real-Time PT Waskita Angkasa Satya</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.dashboard.excel') }}" class="bg-emerald-50 hover:bg-emerald-100 transition-colors text-emerald-700 border border-emerald-200 px-4 py-2 rounded-xl text-sm font-bold shadow-sm inline-block">Export Excel</a>
            <a href="{{ route('admin.dashboard.pdf') }}" target="_blank" class="bg-gray-900 hover:bg-black transition-colors text-white px-4 py-2 rounded-xl text-sm font-bold shadow-md transform hover:-translate-y-0.5 inline-block">Cetak PDF</a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-gray-50 rounded-full z-0"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Personel</p>
                <h3 class="text-4xl font-black text-gray-900">{{ $totalPersonel }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-gray-50 rounded-full z-0"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Lokasi Aktif</p>
                <h3 class="text-4xl font-black text-gray-900">{{ $totalKlien }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full z-0"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Laporan Hari Ini</p>
                <h3 class="text-4xl font-black text-gray-900">{{ $laporanHariIni }}</h3>
            </div>
        </div>
        <div class="bg-amber-400 p-6 rounded-3xl shadow-lg shadow-amber-400/30 relative overflow-hidden transform hover:-translate-y-1 transition-transform">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-300 rounded-full z-0"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-amber-900 uppercase tracking-widest mb-1">Insiden Kritis</p>
                <h3 class="text-4xl font-black text-gray-900">{{ $insidenHariIni }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-gray-900 rounded-3xl p-6 md:p-8 shadow-xl flex flex-col md:flex-row items-center gap-6 border border-gray-800 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 w-16 h-16 shrink-0 bg-amber-400/20 border border-amber-400/30 text-amber-400 rounded-2xl flex items-center justify-center shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
            </svg>
        </div>
        <div class="relative z-10 flex-1 text-center md:text-left">
            <h4 class="text-white font-black text-lg tracking-wide">Pusat Siaran Instruksi (Broadcast)</h4>
            <p class="text-gray-400 text-sm mt-1 font-medium">Kirim peringatan cuaca, SOP baru, atau instruksi darurat yang akan muncul di layar aplikasi seluruh personel lapangan saat ini juga.</p>
        </div>
        <div class="relative z-10 w-full md:w-auto">
            <button onclick="document.getElementById('broadcastModal').classList.remove('hidden')" class="w-full md:w-auto bg-amber-400 hover:bg-amber-300 text-gray-900 px-6 py-3.5 rounded-xl font-black text-sm uppercase tracking-wider transition-all shadow-lg shadow-amber-400/20 transform hover:-translate-y-0.5 whitespace-nowrap flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Buat Pengumuman
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-3xl border border-gray-100 shadow-sm min-h-[450px] flex flex-col">
            <h4 class="font-black text-gray-900 uppercase tracking-tight mb-6 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                Peta Sebaran Personel (Live)
            </h4>
            <div id="map" class="w-full flex-1 border border-gray-200 shadow-inner"></div>
        </div>

        <div class="bg-gray-900 p-6 md:p-8 rounded-3xl shadow-xl flex flex-col gap-6 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-gray-800 rounded-full z-0"></div>
            
            <div class="relative z-10">
                <h4 class="font-black text-amber-400 uppercase tracking-tight mb-5 italic flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005z" clip-rule="evenodd" /></svg>
                    Top 3 Disiplin
                </h4>
                <div class="space-y-3">
                    @forelse($topPersonel as $index => $tp)
                    <div class="flex items-center justify-between bg-white/5 hover:bg-white/10 transition-colors p-3.5 rounded-xl border border-white/10">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-amber-400 text-gray-900 flex justify-center items-center font-black text-xs shadow-md">{{ $index + 1 }}</div>
                            <span class="text-sm font-bold text-white">{{ $tp->personel->nama_lengkap }}</span>
                        </div>
                        <span class="text-[10px] font-bold text-amber-300 uppercase tracking-wider bg-amber-400/10 px-2 py-1 rounded">{{ $tp->total_hadir }} Hari</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 italic">Belum ada data absensi bulan ini.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-auto relative z-10">
                <div class="bg-red-500/10 border border-red-500/20 p-5 rounded-2xl">
                    <h5 class="text-xs font-black text-red-400 uppercase mb-2 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        Titik Rawan Utama
                    </h5>
                    @if($lokasiRawan)
                        <p class="text-base text-white font-bold leading-tight">{{ $lokasiRawan->client->nama_perusahaan }}</p>
                        <p class="text-[10px] text-red-300 mt-1.5 font-bold uppercase tracking-widest">{{ $lokasiRawan->total_insiden }} Insiden Tercatat</p>
                    @else
                        <p class="text-sm text-gray-400 font-medium">Belum ada data insiden dilaporkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 md:p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h4 class="font-black text-gray-900 uppercase tracking-tight">Tren Kehadiran</h4>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">7 Hari Terakhir</p>
                </div>
            </div>
            <div id="attendanceChart" class="w-full flex-1"></div>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h4 class="font-black text-gray-900 uppercase tracking-tight">Distribusi Laporan</h4>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Akumulasi Bulan Ini</p>
                </div>
            </div>
            <div id="reportChart" class="w-full flex-1"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 md:p-8 border-b border-gray-50 flex justify-between items-center bg-white">
                <h4 class="font-black text-gray-900 uppercase tracking-tight">Aktivitas Laporan Terbaru</h4>
                <a href="{{ route('admin.report.index') }}" class="text-xs font-bold text-amber-500 hover:text-amber-600 uppercase tracking-widest transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <th class="px-6 py-4">Personel</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4 text-center">Tipe</th>
                            <th class="px-6 py-4">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($laporanTerbaru as $report)
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="px-6 py-4 align-middle">
                                <span class="text-sm font-bold text-gray-900">{{ $report->personel->nama_lengkap }}</span>
                            </td>
                            <td class="px-6 py-4 align-middle text-sm text-gray-600 font-medium">
                                {{ $report->personel->client->nama_perusahaan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider {{ $report->tipe_laporan == 'insiden' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-emerald-50 text-emerald-600 border border-emerald-200' }}">
                                    {{ $report->tipe_laporan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-xs text-gray-500 font-bold">
                                {{ $report->created_at->format('H:i') }} WIB
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm font-medium text-gray-500">Belum ada laporan baru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 md:p-8 flex flex-col h-[400px]">
            <div class="flex items-center gap-2 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-amber-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h4 class="font-black text-gray-900 uppercase tracking-tight">Linimasa Live</h4>
            </div>
            
            <div class="relative pl-4 space-y-6 border-l-2 border-gray-100 flex-1 overflow-y-auto timeline-scroll pr-2">
                
                <div class="relative">
                    <div class="absolute -left-[21px] top-1 w-3 h-3 bg-emerald-400 rounded-full border-2 border-white shadow-sm"></div>
                    <p class="text-[10px] font-bold text-gray-400 mb-0.5">Baru saja</p>
                    <p class="text-sm font-black text-gray-900 leading-tight">Sistem <span class="font-medium text-gray-600">berhasil membackup data mingguan.</span></p>
                </div>

                <div class="relative">
                    <div class="absolute -left-[21px] top-1 w-3 h-3 bg-amber-400 rounded-full border-2 border-white shadow-sm"></div>
                    <p class="text-[10px] font-bold text-gray-400 mb-0.5">15 Menit lalu</p>
                    <p class="text-sm font-black text-gray-900 leading-tight">Albert Ashley <span class="font-medium text-gray-600">melaporkan giat patroli rutin.</span></p>
                </div>

                <div class="relative">
                    <div class="absolute -left-[21px] top-1 w-3 h-3 bg-blue-400 rounded-full border-2 border-white shadow-sm"></div>
                    <p class="text-[10px] font-bold text-gray-400 mb-0.5">08:15 WIB</p>
                    <p class="text-sm font-black text-gray-900 leading-tight">Zayn Malik <span class="font-medium text-gray-600">melakukan absensi masuk (Hadir).</span></p>
                </div>

                <div class="relative">
                    <div class="absolute -left-[21px] top-1 w-3 h-3 bg-red-400 rounded-full border-2 border-white shadow-sm"></div>
                    <p class="text-[10px] font-bold text-gray-400 mb-0.5">Kemarin, 22:30 WIB</p>
                    <p class="text-sm font-black text-gray-900 leading-tight">Rudi Kansa <span class="font-medium text-gray-600">mengirim laporan insiden kritis.</span></p>
                </div>
                
            </div>
            
            <button onclick="alert('Log lengkap segera dibuat!')" class="mt-4 w-full text-xs font-bold text-gray-600 hover:text-gray-900 text-center uppercase tracking-widest py-3 border border-gray-200 hover:border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors shadow-sm">
                Buka Log Sistem
            </button>
        </div>

    </div>
</div>

<!-- Modal Broadcast -->
<div id="broadcastModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-gray-950/80 backdrop-blur-sm" onclick="document.getElementById('broadcastModal').classList.add('hidden')"></div>
    <div class="bg-gray-900 border border-gray-800 p-8 rounded-3xl shadow-2xl relative z-10 w-full max-w-lg transform transition-all">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-black text-white flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                BUAT PENGUMUMAN
            </h3>
            <button onclick="document.getElementById('broadcastModal').classList.add('hidden')" class="text-gray-400 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <form action="{{ route('admin.broadcast.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label for="judul" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">Judul Instruksi</label>
                <input type="text" name="judul" id="judul" required placeholder="Contoh: SIAGA 1 - CUACA BURUK" class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent placeholder-gray-500 transition-shadow">
            </div>
            
            <div class="mb-8">
                <label for="isi_pesan" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">Isi Instruksi Komando</label>
                <textarea name="isi_pesan" id="isi_pesan" rows="4" required placeholder="Tulis instruksi lengkap di sini..." class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent placeholder-gray-500 transition-shadow resize-none"></textarea>
            </div>
            
            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-gray-900 font-black text-lg py-4 rounded-xl shadow-lg shadow-amber-500/20 translate-y-0 hover:-translate-y-0.5 transition-all uppercase tracking-widest flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                BROADCAST SEKARANG
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // ==========================================
        // 1. Inisialisasi Peta (Kode Asli Dipertahankan)
        // ==========================================
        var map = L.map('map').setView([3.5952, 98.6722], 12); 
        L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
            maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);

        var securityIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
            iconSize: [30, 30], iconAnchor: [15, 30], popupAnchor: [0, -30]
        });

        var attendances = @json($attendancesMap ?? []);
        attendances.forEach(function(absen) {
            if(absen.koordinat_masuk) {
                var coords = absen.koordinat_masuk.split(',');
                L.marker([parseFloat(coords[0]), parseFloat(coords[1])], {icon: securityIcon})
                 .addTo(map)
                 .bindPopup(`<strong>${absen.personel.nama_lengkap}</strong><br>${absen.personel.client ? absen.personel.client.nama_perusahaan : '-'}`);
            }
        });

        // ==========================================
        // 2. Inisialisasi Grafik Kehadiran (ApexCharts)
        // ==========================================
        var attendanceOptions = {
            series: [{
                name: 'Personel Hadir',
                data: [31, 40, 28, 51, 42, 109, 100] // DUMMY DATA: Ganti dari Controller nanti
            }],
            chart: {
                height: 280,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'inherit'
            },
            colors: ['#fbbf24'], // Warna Amber-400
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Ming'],
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: { show: false },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            }
        };
        var attendanceChart = new ApexCharts(document.querySelector("#attendanceChart"), attendanceOptions);
        attendanceChart.render();

        // ==========================================
        // 3. Inisialisasi Grafik Laporan (ApexCharts)
        // ==========================================
        var reportOptions = {
            series: [{
                name: 'Jumlah',
                data: [44, 12] // DUMMY DATA: [Patroli, Insiden]
            }],
            chart: {
                height: 280,
                type: 'bar',
                toolbar: { show: false },
                fontFamily: 'inherit'
            },
            colors: ['#10b981', '#ef4444'], // Emerald untuk Patroli, Red untuk Insiden
            plotOptions: {
                bar: { columnWidth: '45%', borderRadius: 6, distributed: true }
            },
            dataLabels: { enabled: false },
            legend: { show: false },
            xaxis: {
                categories: ['Patroli Rutin', 'Insiden Kritis'],
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: { show: false },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
            }
        };
        var reportChart = new ApexCharts(document.querySelector("#reportChart"), reportOptions);
        reportChart.render();

    });
</script>
@endpush