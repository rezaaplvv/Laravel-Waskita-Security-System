<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Personel;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $personel = Personel::where('user_id', Auth::id())->first();
        
        // Mengambil laporan & absensi personel ini, terbaru
        $reports = Report::where('personel_id', $personel->id)
                         ->latest()
                         ->get();

        $attendances = Attendance::where('personel_id', $personel->id)
                                 ->orderBy('tanggal', 'desc')
                                 ->get();

        return view('personel.report.index', compact('reports', 'attendances'));
    }

    // Menampilkan form laporan
    public function create()
    {
        // Cek apakah personel sudah di-plotting ke lokasi tertentu
        $personel = Personel::with('client')->where('user_id', Auth::id())->first();

        if (!$personel || !$personel->client_id) {
            return redirect()->route('personel.dashboard')->with('error', 'Anda belum ditugaskan ke lokasi manapun. Hubungi Admin.');
        }

        return view('personel.report.create', compact('personel'));
    }

    // Memproses data kiriman laporan
    public function store(Request $request)
    {
        $request->validate([
            'tipe_laporan' => 'required|in:patroli,insiden',
            'deskripsi' => 'required|string',
            'koordinat_gps' => 'nullable|string', // Berasal dari titik GPS browser/HP
            'foto_kejadian' => 'nullable|image|mimes:jpg,jpeg,png|max:2048' // Opsional untuk patroli, tapi UI bisa memaksa jika insiden
        ]);

        $personel = Personel::where('user_id', Auth::id())->first();

        // Proses Upload Foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto_kejadian')) {
            $fotoFile = $request->file('foto_kejadian');
            $fotoNama = time() . '_laporan_' . $personel->nip . '.' . $fotoFile->getClientOriginalExtension();
            $fotoFile->storeAs('laporan', $fotoNama, 'public');
            $fotoPath = 'laporan/' . $fotoNama;
        }

        // Simpan ke database
        Report::create([
            'personel_id' => $personel->id,
            'client_id' => $personel->client_id, // Otomatis masuk ke data Klien yang sudah di-plotting
            'tipe_laporan' => $request->tipe_laporan,
            'deskripsi' => $request->deskripsi,
            'foto_kejadian' => $fotoPath,
            'koordinat_gps' => $request->koordinat_gps,
        ]);

        return redirect()->route('personel.dashboard')->with('success', 'Laporan berhasil dikirim ke pusat!');
    }

    /**
     * Menampilkan riwayat aktivitas absensi dan laporan milik personel.
     * Terintegrasi dengan tampilan mobile tab view.
     */
    public function history()
    {
        // 1. Ambil data personel berdasarkan user yang login
        $personel = Personel::where('user_id', Auth::id())->first();

        if (!$personel) {
            return redirect()->route('personel.dashboard')->with('error', 'Data personel tidak ditemukan.');
        }

        // 2. Ambil riwayat kehadiran (maksimal 30 data terbaru)
        $absensiList = Attendance::where('personel_id', $personel->id)
                        ->orderBy('tanggal', 'desc')
                        ->limit(30)
                        ->get();

        // 3. Ambil riwayat laporan lapangan (maksimal 30 data terbaru)
        $laporanList = Report::where('personel_id', $personel->id)
                        ->orderBy('created_at', 'desc')
                        ->limit(30)
                        ->get();

        // 4. Kirim ke view history yang telah diperbarui
        return view('personel.history', compact('absensiList', 'laporanList'));
    }
    public function profile()
{
    // Ambil data personel yang sedang login
    $personel = Personel::with('client')->where('user_id', Auth::id())->first();

    if (!$personel) {
        return redirect()->route('personel.dashboard')->with('error', 'Data personel tidak ditemukan.');
    }

    return view('personel.profile', compact('personel'));
}
}