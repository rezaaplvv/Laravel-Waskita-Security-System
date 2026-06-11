@extends('layouts.app')

@section('title', 'Tindak Lanjut Laporan')
@section('header', 'Verifikasi Laporan')

@section('content')
<div class="space-y-6">

    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col lg:flex-row justify-between lg:items-center gap-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-32 h-32 bg-amber-50 rounded-bl-[100px] -z-10"></div>
        
        <div>
            <h2 class="text-2xl font-black text-gray-900 mb-1">Verifikasi & Tindak Lanjut Lapangan</h2>
            <p class="text-sm text-gray-500 font-medium">Berikan instruksi atau catatan penyelesaian pada laporan yang masuk dari personel keamanan.</p>
        </div>

        <div class="flex p-1 bg-gray-50 rounded-xl border border-gray-200 shadow-inner shrink-0">
            <a href="{{ route('supervisor.report.index') }}" class="px-4 py-2 text-xs font-bold uppercase tracking-widest rounded-lg transition {{ !request('tipe') ? 'bg-white text-gray-900 shadow-sm border border-gray-200' : 'text-gray-400 hover:text-gray-600' }}">
                Semua
            </a>
            <a href="{{ route('supervisor.report.index', ['tipe' => 'patroli']) }}" class="px-4 py-2 text-xs font-bold uppercase tracking-widest rounded-lg transition {{ request('tipe') == 'patroli' ? 'bg-emerald-50 text-emerald-700 shadow-sm border border-emerald-100' : 'text-gray-400 hover:text-gray-600' }}">
                Patroli
            </a>
            <a href="{{ route('supervisor.report.index', ['tipe' => 'insiden']) }}" class="px-4 py-2 text-xs font-bold uppercase tracking-widest rounded-lg transition {{ request('tipe') == 'insiden' ? 'bg-red-50 text-red-700 shadow-sm border border-red-100' : 'text-gray-400 hover:text-gray-600' }}">
                Insiden
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 p-4 rounded-2xl border border-emerald-100 text-sm font-bold flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4">
        @forelse($reports as $report)
            <div class="bg-white rounded-[2rem] shadow-sm border {{ $report->tipe_laporan == 'insiden' && empty($report->catatan_supervisor) ? 'border-red-200 ring-2 ring-red-50' : 'border-gray-100' }} p-6 flex flex-col md:flex-row gap-6 hover:shadow-md transition">
                
                <div class="md:w-56 shrink-0 flex flex-col md:border-r border-gray-100 md:pr-6">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('l, d M Y') }}</p>
                    <p class="text-2xl font-black text-gray-900 leading-none mb-3">{{ \Carbon\Carbon::parse($report->created_at)->format('H:i') }} <span class="text-xs font-bold text-gray-400">WIB</span></p>
                    
                    <div class="mb-3">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Lokasi Insiden / Patroli:</p>
                        <p class="text-sm font-black text-gray-800 leading-tight">{{ $report->client->nama_perusahaan ?? 'Area Publik' }}</p>
                    </div>

                    @if($report->tipe_laporan == 'insiden')
                        <div class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-red-100 w-max mt-auto">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" /></svg>
                            ⚠️ INSIDEN
                        </div>
                    @else
                        <div class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-emerald-100 w-max mt-auto">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            PATROLI RUTIN
                        </div>
                    @endif
                </div>

                <div class="flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-3">
                            @if($report->personel->user->foto_profil ?? false)
                                <img src="{{ asset('storage/' . $report->personel->user->foto_profil) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center font-bold text-sm">
                                    {{ substr($report->personel->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-black text-gray-900 text-base leading-tight">{{ $report->personel->nama_lengkap }}</p>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-0.5">Personel Keamanan</p>
                            </div>
                        </div>
                        
                        @if($report->foto_kejadian)
                            <button type="button" onclick="viewPhoto('{{ asset('storage/' . $report->foto_kejadian) }}')" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 border border-blue-100 px-3 py-2 rounded-lg hover:bg-blue-100 transition shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                Lihat Bukti
                            </button>
                        @endif
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 mb-4">
                        <p class="text-sm text-gray-700 leading-relaxed font-medium">"{{ $report->deskripsi }}"</p>
                    </div>

                    <div class="mt-auto border-t border-gray-100 pt-4">
                        @if(empty($report->catatan_supervisor))
                            <div class="flex items-center justify-between bg-amber-50 border border-amber-100 rounded-xl p-4">
                                <p class="text-xs font-bold text-amber-700">Laporan ini belum diverifikasi/ditindaklanjuti.</p>
                                <button type="button" onclick="openRespondModal({{ $report->id }}, '')" class="bg-amber-500 hover:bg-amber-600 text-gray-900 text-xs font-black uppercase tracking-widest px-4 py-2 rounded-lg shadow-sm transition">
                                    Tindak Lanjut
                                </button>
                            </div>
                        @else
                            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 relative group">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-700">Instruksi Komando (Tindak Lanjut)</p>
                                </div>
                                <p class="text-sm font-bold text-emerald-900">{{ $report->catatan_supervisor }}</p>
                                
                                <button type="button" onclick="openRespondModal({{ $report->id }}, '{{ addslashes($report->catatan_supervisor) }}')" class="absolute top-4 right-4 text-[10px] font-bold text-emerald-600 hover:text-emerald-800 bg-emerald-100 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                                    Ubah Catatan
                                </button>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white p-12 rounded-[2rem] text-center border-2 border-dashed border-gray-200">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                </div>
                <h3 class="text-lg font-black text-gray-900 mb-1">Tidak Ada Laporan</h3>
                <p class="text-gray-500 font-medium text-sm">Sistem tidak menemukan laporan yang cocok dengan filter Anda.</p>
            </div>
        @endforelse

        @if($reports->hasPages())
            <div class="mt-6">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>

<div id="respond-modal" class="hidden fixed inset-0 bg-gray-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white rounded-[2rem] overflow-hidden shadow-2xl max-w-md w-full p-8 relative border border-gray-100">
        
        <div class="flex justify-between items-center mb-6">
            <h4 class="font-black text-gray-900 text-xl">Instruksi Komando</h4>
            <button type="button" onclick="closeRespondModal()" class="w-8 h-8 bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-full flex items-center justify-center transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form id="respond-form" method="POST" action="">
            @csrf
            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2 pl-1">Catatan / Tindakan Supervisor</label>
                <textarea name="catatan_supervisor" id="catatan_supervisor" rows="4" required placeholder="Contoh: Tim teknisi sudah dihubungi dan akan menuju lokasi untuk perbaikan pintu..." class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-sm font-medium text-gray-900 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 shadow-inner resize-none"></textarea>
                <p class="text-xs text-gray-500 mt-2 font-medium">Catatan ini akan diteruskan ke portal Klien sebagai bukti bahwa PT Waskita telah merespons kondisi lapangan.</p>
            </div>

            <div class="mt-8 flex gap-3">
                <button type="button" onclick="closeRespondModal()" class="w-1/3 py-3.5 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="w-2/3 py-3.5 bg-gray-900 text-amber-400 font-black uppercase tracking-widest rounded-xl shadow-lg shadow-gray-900/20 hover:bg-black transition">Simpan Catatan</button>
            </div>
        </form>

    </div>
</div>

<div id="photo-modal" class="hidden fixed inset-0 bg-gray-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-4" onclick="closePhoto()">
    <div class="bg-white rounded-[2rem] overflow-hidden shadow-2xl max-w-lg w-full p-6 relative border border-gray-100" onclick="event.stopPropagation()">
        <img id="modal-img" src="" alt="Bukti Lapangan" class="w-full max-h-[70vh] object-contain rounded-2xl border bg-gray-50 mb-4">
        <button type="button" onclick="closePhoto()" class="w-full py-3 bg-gray-100 font-bold text-gray-600 rounded-xl hover:bg-gray-200 transition">Tutup Pratinjau</button>
    </div>
</div>

<script>
    function openRespondModal(id, existingNote) {
        const modal = document.getElementById('respond-modal');
        const form = document.getElementById('respond-form');
        const textarea = document.getElementById('catatan_supervisor');
        
        // Dynamically set action URL
        form.action = `/supervisor/laporan/${id}/respond`;
        textarea.value = existingNote; // Auto-fill if editing
        
        modal.classList.remove('hidden');
    }

    function closeRespondModal() {
        document.getElementById('respond-modal').classList.add('hidden');
    }

    function viewPhoto(src) {
        document.getElementById('modal-img').src = src;
        document.getElementById('photo-modal').classList.remove('hidden');
    }

    function closePhoto() {
        document.getElementById('photo-modal').classList.add('hidden');
    }
</script>
@endsection