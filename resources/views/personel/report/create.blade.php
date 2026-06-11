@extends('layouts.app')

@section('title', 'Laporan Patroli Lapangan')

@push('styles')
<style>
    /* Menyembunyikan sidebar/navbar bawaan khusus untuk tampilan HP */
    @media (max-width: 768px) {
        aside, header { display: none !important; }
        main { padding: 0 !important; background-color: #f9fafb; }
    }
    /* Memodifikasi tampilan Select agar panah panahnya lebih rapi */
    select { background-position: right 1rem center !important; }
</style>
@endpush

@section('content')
<div class="max-w-md mx-auto bg-gray-50 min-h-screen relative shadow-2xl overflow-hidden pb-10">

    <div class="bg-gray-900 px-6 pt-12 pb-24 rounded-b-[2.5rem] relative shadow-lg">
        <div class="flex items-center gap-4 relative z-10">
            <a href="{{ route('personel.dashboard') }}" class="w-10 h-10 bg-gray-800 rounded-2xl flex items-center justify-center text-amber-400 hover:bg-gray-700 transition active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
            <div>
                <h2 class="text-white text-xl font-black tracking-tight">Laporan Patroli</h2>
                <p class="text-amber-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Kirim Kondisi Lapangan</p>
            </div>
        </div>
    </div>

    <div class="-mt-14 px-6 relative z-20 mb-8">
        <div class="bg-white rounded-[2rem] p-5 shadow-xl shadow-gray-200/60 border border-gray-100 flex items-start gap-4">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl border border-amber-100 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-amber-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Lokasi Dipantau</p>
                <p class="text-sm font-black text-gray-900 leading-tight">{{ $personel->client->nama_perusahaan ?? 'Belum ada data' }}</p>
                <p class="text-xs font-medium text-gray-500 mt-1">{{ $personel->client->lokasi_penjagaan ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="px-6">
        <form action="{{ route('personel.report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2 pl-1">Kategori Laporan</label>
                <div class="relative">
                    <select name="tipe_laporan" id="tipe_laporan" required class="w-full bg-white border border-gray-200 rounded-2xl p-4 pr-12 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 shadow-sm transition-all appearance-none">
                        <option value="patroli">Patroli Rutin (Aman & Kondusif)</option>
                        <option value="insiden">Laporan Insiden / Kerusakan</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2 pl-1">Deskripsi Kondisi</label>
                <textarea name="deskripsi" rows="4" required class="w-full bg-white border border-gray-200 rounded-2xl p-4 text-sm font-medium text-gray-900 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 shadow-sm transition-all resize-none" placeholder="Jelaskan kondisi area yang dipantau dengan singkat dan jelas..."></textarea>
            </div>

            <div>
                <div class="flex justify-between items-end mb-2 pl-1 pr-1">
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest">Foto Bukti</label>
                    <span class="text-[10px] font-bold text-amber-500 bg-amber-50 px-2 py-0.5 rounded">Wajib untuk Insiden</span>
                </div>
                
                <div class="relative group">
                    <input type="file" name="foto_kejadian" id="foto_kejadian" accept="image/*" capture="environment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div id="upload-placeholder" class="bg-white border-2 border-dashed border-gray-300 rounded-3xl p-8 text-center flex flex-col items-center justify-center transition-colors group-hover:bg-gray-50 shadow-sm">
                        <div class="w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center mb-3 text-gray-400 group-hover:text-amber-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                        </div>
                        <span class="text-sm font-black text-gray-900">Buka Kamera</span>
                        <span class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-wider">Ketuk untuk mengambil foto</span>
                    </div>
                    <div id="image-preview-container" class="hidden relative rounded-3xl overflow-hidden shadow-md border-4 border-white">
                        <img id="image-preview" src="" alt="Preview" class="w-full h-48 object-cover">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <span class="text-white text-xs font-bold uppercase tracking-widest bg-black/50 px-3 py-1.5 rounded-lg">Ketuk untuk mengganti</span>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2 pl-1">Tag Lokasi Keamanan</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg id="gps-icon" class="w-5 h-5 text-gray-400 animate-pulse" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>
                    <input type="text" name="koordinat_gps" id="koordinat_gps" readonly required class="w-full pl-11 pr-4 py-4 bg-gray-100 border border-gray-200 rounded-2xl text-xs font-mono font-bold text-gray-600 focus:outline-none shadow-inner" placeholder="Mencari titik koordinat...">
                </div>
                <p class="text-[10px] text-red-500 font-bold mt-2 hidden px-1" id="gps-error">Gagal mengunci lokasi. Pastikan izin GPS peramban aktif!</p>
            </div>

            <div class="pt-4 pb-8">
                <button type="submit" id="submit-btn" class="w-full group relative flex justify-center items-center py-4 px-6 rounded-[2rem] bg-gray-900 text-white overflow-hidden transition-all active:scale-95 shadow-xl shadow-gray-900/20 disabled:opacity-50 disabled:cursor-not-allowed">
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-amber-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <span class="relative z-10 flex items-center gap-2 text-sm font-black uppercase tracking-widest group-hover:text-gray-900 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                        Kirim Laporan
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. LOGIKA GPS ---
        const gpsInput = document.getElementById('koordinat_gps');
        const errorMsg = document.getElementById('gps-error');
        const gpsIcon = document.getElementById('gps-icon');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    gpsInput.value = lat + ", " + lng;
                    
                    // Update UI jika berhasil
                    gpsIcon.classList.remove('animate-pulse', 'text-gray-400');
                    gpsIcon.classList.add('text-emerald-500');
                    gpsInput.classList.remove('bg-gray-100', 'text-gray-600');
                    gpsInput.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-200');
                },
                function(error) {
                    gpsInput.value = "GPS Tidak Terdeteksi";
                    errorMsg.classList.remove('hidden');
                    gpsIcon.classList.remove('animate-pulse');
                    gpsIcon.classList.add('text-red-500');
                },
                { enableHighAccuracy: true }
            );
        } else {
            gpsInput.value = "Browser tidak mendukung GPS";
        }

        // --- 2. LOGIKA IMAGE PREVIEW (BARU) ---
        const fileInput = document.getElementById('foto_kejadian');
        const placeholder = document.getElementById('upload-placeholder');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Sembunyikan placeholder kotak putus-putus
                placeholder.classList.add('hidden');
                // Tampilkan container foto
                previewContainer.classList.remove('hidden');
                // Masukkan file ke tag img
                previewImage.src = URL.createObjectURL(file);
            }
        });
    });
</script>
@endsection