@extends('layouts.app')

@section('title', 'Tambah Personel Baru')
@section('header', 'Pendaftaran Personel Security')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.personel.index') }}" class="flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-amber-500 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm flex items-start gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 shrink-0 mt-0.5 text-red-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <p class="font-black text-sm uppercase tracking-wider mb-1">Terjadi Kesalahan</p>
                <ul class="list-disc list-inside text-sm font-medium space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        
        <div class="p-8 border-b border-gray-50 bg-gray-900 text-white">
            <h3 class="text-xl font-black tracking-tight">Formulir Pendaftaran Personel</h3>
            <p class="text-sm text-gray-400 font-medium mt-1">Sistem akan otomatis membuatkan akun akses login setelah data disimpan.</p>
        </div>

        <form action="{{ route('admin.personel.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                
                <div class="space-y-6">
                    <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-amber-500"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" /></svg>
                        <h4 class="text-sm font-black text-gray-900 uppercase tracking-widest">Informasi Dasar</h4>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Foto Profil (Pas Foto Resmi)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="foto-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500 px-2 py-0.5">
                                        <span>Pilih File</span>
                                        <input id="foto-upload" name="foto_profil" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                                    </label>
                                </div>
                                <p class="text-[10px] text-gray-500 mt-1 uppercase">PNG, JPG, JPEG maks 2MB</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nomor Induk Personel (NIP)</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" required placeholder="Contoh: 12345678" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 focus:bg-white transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Masukkan nama lengkap sesuai KTP" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 focus:bg-white transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 focus:bg-white transition-all">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">No. Handphone</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="0812..." class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 focus:bg-white transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Domisili</label>
                        <textarea name="alamat" rows="3" required placeholder="Tuliskan alamat lengkap..." class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 focus:bg-white transition-all">{{ old('alamat') }}</textarea>
                    </div>
                </div>

                <div class="space-y-6">
                    
                    <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-blue-500"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                        <h4 class="text-sm font-black text-gray-900 uppercase tracking-widest">Kredensial Login</h4>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Aktif</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="personel@waskita.com" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:bg-white transition-all">
                        <p class="text-[10px] text-gray-400 mt-2 font-medium">*Email ini akan digunakan personel untuk masuk ke aplikasi mobile/web.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password Default</label>
                        <input type="password" name="password" required placeholder="••••••••" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:bg-white transition-all">
                        <p class="text-[10px] text-gray-400 mt-2 font-medium">*Minimal 8 karakter. Disarankan menggunakan kombinasi angka dan huruf.</p>
                    </div>

                    <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-3 pt-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-emerald-500"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                        <h4 class="text-sm font-black text-gray-900 uppercase tracking-widest">Penempatan Tugas</h4>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Lokasi Klien (Opsional)</label>
                        <select name="client_id" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 focus:bg-white transition-all">
                            <option value="">-- Biarkan kosong jika status Standby --</option>
                            
                            @if(isset($clients) && $clients->count() > 0)
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->nama_perusahaan }} ({{ $client->lokasi_penjagaan }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <p class="text-[10px] text-emerald-600 mt-2 font-bold">*Personel hanya bisa melakukan absen jika sudah diploting ke lokasi klien.</p>
                    </div>

                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mt-10 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.personel.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors">
                    Batal
                </a>
                <button type="submit" class="flex items-center gap-2 px-8 py-3 bg-amber-400 text-gray-900 rounded-xl text-sm font-black uppercase tracking-widest hover:bg-amber-300 transition-all shadow-lg shadow-amber-400/30 transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Simpan Personel
                </button>
            </div>
        </form>

    </div>
</div>
@endsection