<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Personel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Memproses Absen Masuk atau Pulang
    public function store(Request $request)
    {
        // Validasi foto (wajib ada, format gambar, maksimal 10MB) dan koordinat GPS
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'koordinat_gps' => 'required|string', // Tambahan: Wajib ada data GPS
        ]);

        $personel = Personel::where('user_id', Auth::id())->first();
        $hariIni = Carbon::today()->toDateString();
        $sekarang = Carbon::now()->toTimeString();

        // Simpan foto ke folder storage/app/public/absensi
        $fotoPath = $request->file('foto')->store('absensi', 'public');

        $absensi = Attendance::where('personel_id', $personel->id)
                             ->where('tanggal', $hariIni)
                             ->first();

        if (!$absensi) {
            // PROSES ABSEN MASUK
            Attendance::create([
                'personel_id' => $personel->id,
                'tanggal' => $hariIni,
                'jam_masuk' => $sekarang,
                'foto_masuk' => $fotoPath,
                'koordinat_masuk' => $request->koordinat_gps, // Tambahan: Simpan GPS Masuk
                'status' => 'Hadir'
            ]);
            return back()->with('success', 'Berhasil Absen Masuk beserta Lokasi GPS!');
        } elseif ($absensi && !$absensi->jam_pulang) {
            // PROSES ABSEN PULANG
            $absensi->update([
                'jam_pulang' => $sekarang,
                'foto_pulang' => $fotoPath,
                'koordinat_pulang' => $request->koordinat_gps // Tambahan: Simpan GPS Pulang
            ]);
            return back()->with('success', 'Berhasil Absen Pulang beserta Lokasi GPS. Terima kasih atas kerja keras Anda!');
        } else {
            return back()->with('error', 'Anda sudah menyelesaikan absensi hari ini.');
        }
    }
}