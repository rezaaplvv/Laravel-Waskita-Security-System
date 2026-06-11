@extends('layouts.app')

@section('title', 'Data Personel')
@section('header', 'Manajemen Data Personel')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
        
        <div class="p-6 md:p-8 border-b border-gray-50 space-y-4 md:space-y-0 md:flex md:items-center md:justify-between bg-white">
            <div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Daftar Personel Security</h3>
                <p class="text-xs text-gray-500 font-medium mt-1">Kelola data anggota, kontak, dan penugasan operasional.</p>
            </div>
            
            <form action="{{ route('admin.personel.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIP atau Nama..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all">
                    <button type="submit" class="hidden"></button>
                </div>

                <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl py-2.5 pl-4 pr-8 focus:ring-amber-400 focus:border-amber-400 font-medium transition-all">
                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif Bertugas</option>
                    <option value="standby" {{ request('status') == 'standby' ? 'selected' : '' }}>Standby</option>
                </select>

                <a href="{{ route('admin.personel.create') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-amber-400 hover:bg-amber-300 text-gray-900 px-5 py-2.5 rounded-xl font-black text-sm uppercase tracking-wider transition-all shadow-lg shadow-amber-400/30 transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah
                </a>
            </form>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-5">Personel</th>
                        <th class="px-8 py-5">Kontak & Akses</th>
                        <th class="px-8 py-5 text-center">Gender</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    
                    @forelse($personels as $personel)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                @if($personel->user && $personel->user->foto_profil)
                                    <img src="{{ asset('storage/' . $personel->user->foto_profil) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200 shadow-sm transition-transform group-hover:scale-105">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-amber-100 border border-amber-200 text-amber-700 flex items-center justify-center font-black text-sm shadow-sm group-hover:bg-amber-400 group-hover:text-gray-900 transition-colors">
                                        {{ strtoupper(substr($personel->nama_lengkap, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $personel->nama_lengkap }}</p>
                                    <p class="text-xs text-gray-500 font-medium">NIP: {{ $personel->nip }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-4">
                            <p class="text-sm font-bold text-gray-800">{{ $personel->no_hp ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $personel->user->email ?? 'Email tidak tersedia' }}</p>
                        </td>

                        <td class="px-8 py-4 text-center">
                            <span class="text-xs font-bold text-gray-600">
                                {{ $personel->jenis_kelamin ?? 'Laki-laki' }}
                            </span>
                        </td>

                        <td class="px-8 py-4 text-center">
                            @if($personel->client_id)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Ditugaskan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-600 border border-gray-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Standby
                                </span>
                            @endif
                        </td>

<td class="px-8 py-4 text-right">
    <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">
        
        <a href="{{ route('admin.personel.edit', $personel->id) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-colors border border-blue-100 hover:border-blue-600" title="Edit Data">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
        </a>

        <form action="{{ route('admin.personel.destroy', $personel->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data personel beserta akun loginnya?');" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-colors border border-red-100 hover:border-red-600" title="Hapus Data">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>
        </form>

    </div>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900">Data tidak ditemukan.</p>
                                <p class="text-xs text-gray-500 mt-1">Silakan coba kata kunci pencarian atau filter yang lain.</p>
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