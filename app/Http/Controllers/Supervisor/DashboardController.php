<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personel;
use App\Models\Attendance;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // 1. Kalkulasi Kehadiran Hari Ini
        $totalPersonel = Personel::count();
        $absenMasukHariIni = Attendance::where('tanggal', $today)->count();
        $belumAbsen = $totalPersonel - $absenMasukHariIni;

        // 2. Ambil Daftar Personel yang belum absen hari ini
        $personelSudahAbsenIds = Attendance::where('tanggal', $today)->pluck('personel_id');
        $personelMangkir = Personel::whereNotIn('id', $personelSudahAbsenIds)
                                   ->with('client') // untuk tahu mereka harusnya jaga di mana
                                   ->limit(5)
                                   ->get();

        // 3. Kalkulasi dan Ambil Laporan Insiden Hari Ini
        $insidenHariIni = Report::with(['personel', 'client'])
                                ->where('tipe_laporan', 'insiden')
                                ->whereDate('created_at', $today)
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('supervisor.dashboard', compact(
            'totalPersonel', 
            'absenMasukHariIni', 
            'belumAbsen', 
            'personelMangkir', 
            'insidenHariIni'
        ));
    }

public function attendance()
    {

        $attendances = Attendance::with(['personel.user', 'personel.client'])
                            ->orderBy('tanggal', 'desc')
                            ->orderBy('jam_masuk', 'desc')
                            ->paginate(15);

        return view('supervisor.attendance', compact('attendances'));
    }

public function reports(Request $request)
    {
        // Fitur Filter Tipe Laporan (Semua, Patroli, atau Insiden)
        $query = Report::with(['personel.user', 'client']);

        if ($request->has('tipe') && in_array($request->tipe, ['patroli', 'insiden'])) {
            $query->where('tipe_laporan', $request->tipe);
        }

        // Gunakan pagination agar loading halaman tetap super cepat
        $reports = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('supervisor.report', compact('reports'));
    }

    // Fungsi BARU untuk menyimpan catatan Supervisor
    public function respondReport(Request $request, $id)
    {
        $request->validate([
            'catatan_supervisor' => 'required|string|max:1000'
        ]);

        $report = Report::findOrFail($id);
        $report->update([
            'catatan_supervisor' => $request->catatan_supervisor
        ]);

        return redirect()->back()->with('success', 'Catatan tindak lanjut berhasil disimpan & diteruskan ke Klien!');
    }
}