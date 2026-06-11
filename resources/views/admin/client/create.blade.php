@extends('layouts.app')

@section('title', 'Tambah Data Klien')
@section('header', 'Pendaftaran Mitra & Lokasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.client.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-amber-500 transition-colors group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition-transform">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
            </svg>
            Kembali ke Daftar Mitra
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm flex items-start gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 shrink-0 mt-0.5 text-red-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <p class="font-black text-sm uppercase tracking-wider mb-1">Pendaftaran Gagal</p>
                <ul class="list-disc list-inside text-sm font-medium space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        
        <div class="p-8 border-b border-gray-50 bg-gray-900 text-white relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-40 h-40 bg-amber-500/10 rounded-full blur-2xl"></div>
            
            <div class="relative z-10">
                <h3 class="text-xl font-black tracking-tight">Formulir Identitas Klien Baru</h3>
                <p class="text-sm text-gray-400 font-medium mt-1">Data lokasi penjagaan dan pembuatan akun portal pemantauan untuk mitra.</p>
            </div>
        </div>

        <form action="{{ route('admin.client.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                
                <div class="space-y-6">
                    <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-amber-500"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" /></svg>
                        <h4 class="text-sm font-black text-gray-900 uppercase tracking-widest">Detail Penjagaan</h4>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Perusahaan / Klien</label>
                        <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" required placeholder="Contoh: PT. Angkasa Pura" class="block w-full px-4 py-3 bg-gray-50 border {{ $errors->has('nama_perusahaan') ? 'border-red-400 focus:ring-red-400' : 'border-gray-200 focus:ring-amber-400 focus:border-amber-400' }} rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:bg-white transition-all">
                        @error('nama_perusahaan') <span class="text-[10px] font-bold text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sektor / Lokasi Spesifik</label>
                        <input type="text" name="lokasi_penjagaan" value="{{ old('lokasi_penjagaan') }}" required placeholder="Contoh: Gudang Logistik Sektor A" class="block w-full px-4 py-3 bg-gray-50 border {{ $errors->has('lokasi_penjagaan') ? 'border-red-400 focus:ring-red-400' : 'border-gray-200 focus:ring-amber-400 focus:border-amber-400' }} rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:bg-white transition-all">
                        @error('lokasi_penjagaan') <span class="text-[10px] font-bold text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Lengkap Area</label>
                        <textarea name="alamat_lengkap" rows="4" required placeholder="Tuliskan alamat lengkap lokasi penjagaan..." class="block w-full px-4 py-3 bg-gray-50 border {{ $errors->has('alamat_lengkap') ? 'border-red-400 focus:ring-red-400' : 'border-gray-200 focus:ring-amber-400 focus:border-amber-400' }} rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:bg-white transition-all">{{ old('alamat_lengkap') }}</textarea>
                        @error('alamat_lengkap') <span class="text-[10px] font-bold text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    
                    <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-blue-500"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                        <h4 class="text-sm font-black text-gray-900 uppercase tracking-widest">Akses Portal Klien</h4>
                    </div>
                    
                    <div class="bg-blue-50/50 border border-blue-100 p-4 rounded-xl mb-2">
                        <p class="text-[11px] font-medium text-blue-800 leading-relaxed">
                            Akun ini akan diberikan kepada pihak klien agar mereka dapat *login* dan melihat rekapan laporan aktivitas serta absensi personel yang bertugas di lokasi mereka secara *real-time*.
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Perwakilan Klien</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="hrd@angkasapura.com" class="block w-full px-4 py-3 bg-gray-50 border {{ $errors->has('email') ? 'border-red-400 focus:ring-red-400' : 'border-gray-200 focus:ring-blue-400 focus:border-blue-400' }} rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:bg-white transition-all">
                        @error('email') <span class="text-[10px] font-bold text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password Sementara</label>
                        <input type="password" name="password" required placeholder="••••••••" class="block w-full px-4 py-3 bg-gray-50 border {{ $errors->has('password') ? 'border-red-400 focus:ring-red-400' : 'border-gray-200 focus:ring-blue-400 focus:border-blue-400' }} rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:bg-white transition-all">
                        <p class="text-[10px] text-gray-400 mt-2 font-medium">*Minimal 6 karakter. Sampaikan password ini kepada klien setelah pendaftaran selesai.</p>
                        @error('password') <span class="text-[10px] font-bold text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mt-10 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.client.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors">
                    Batal
                </a>
                <button type="submit" class="flex items-center gap-2 px-8 py-3 bg-amber-400 text-gray-900 rounded-xl text-sm font-black uppercase tracking-widest hover:bg-amber-300 transition-all shadow-lg shadow-amber-400/30 transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Simpan & Daftarkan Klien
                </button>
            </div>
        </form>

    </div>
</div>
@endsection