<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personel;
use App\Models\Client;
use App\Models\Report;
use App\Models\Attendance;
use App\Models\Broadcast;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardExport;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today()->toDateString();
        $bulanIni = Carbon::now()->month;

        // 1. Statistik Utama
        $totalPersonel = Personel::count();
        $totalKlien = Client::count();
        $laporanHariIni = Report::whereDate('created_at', $hariIni)->count();
        $insidenHariIni = Report::where('tipe_laporan', 'insiden')->whereDate('created_at', $hariIni)->count();

        // 2. Data Peta (Personel yang sudah absen masuk hari ini)
        $attendancesMap = Attendance::with(['personel.client'])
                                    ->where('tanggal', $hariIni)
                                    ->whereNotNull('koordinat_masuk')
                                    ->get();

        // 3. Top 3 Personel Disiplin (Berdasarkan jumlah kehadiran bulan ini)
        $topPersonel = Attendance::select('personel_id', DB::raw('count(*) as total_hadir'))
            ->where('status', 'Hadir')
            ->whereMonth('tanggal', $bulanIni)
            ->groupBy('personel_id')
            ->orderBy('total_hadir', 'desc')
            ->take(3)
            ->with('personel')
            ->get();

        // 4. Lokasi Paling Rawan (Client dengan insiden terbanyak bulan ini)
        $lokasiRawan = Report::select('client_id', DB::raw('count(*) as total_insiden'))
            ->where('tipe_laporan', 'insiden')
            ->whereMonth('created_at', $bulanIni)
            ->groupBy('client_id')
            ->orderBy('total_insiden', 'desc')
            ->take(1)
            ->with('client')
            ->first();

        // 5. Peringatan Kontrak (Klien yang kontraknya habis dalam 30 hari ke depan)
        // Sementara di-set kosong karena kolom tanggal_kontrak_berakhir belum ada di tabel clients
        $kontrakAkanHabis = collect();

        // 6. Laporan Aktivitas Terbaru
        $laporanTerbaru = Report::with(['personel.client'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPersonel', 'totalKlien', 'laporanHariIni', 'insidenHariIni', 
            'attendancesMap', 'topPersonel', 'lokasiRawan', 'kontrakAkanHabis', 'laporanTerbaru'
        ));
    }

    public function storeBroadcast(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'isi_pesan' => 'required|string',
        ]);

        // Arsipkan semua broadcast yang aktif
        Broadcast::where('status', 'aktif')->update(['status' => 'arsip']);

        // Buat broadcast baru
        Broadcast::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'isi_pesan' => $validated['isi_pesan'],
            'status' => 'aktif',
        ]);

        return redirect()->back()->with('success', 'Instruksi Komando berhasil di-broadcast!');
    }

    public function exportExcel()
    {
        return Excel::download(new DashboardExport, 'Laporan_Operasional_WAS_' . Carbon::now()->format('Ymd_His') . '.xlsx');
    }

    public function exportPdf()
    {
        $hariIni = Carbon::today()->toDateString();
        
        $totalPersonel = Personel::count();
        $totalKlien = Client::count();
        $laporanHariIni = Report::whereDate('created_at', $hariIni)->count();
        $insidenHariIni = Report::where('tipe_laporan', 'insiden')->whereDate('created_at', $hariIni)->count();

        $attendances = Attendance::with(['personel.client'])
                                 ->where('tanggal', $hariIni)
                                 ->get();

        $reports = Report::with(['personel.client'])
                         ->whereDate('created_at', $hariIni)
                         ->get();

        $pdf = Pdf::loadView('admin.pdf_dashboard', compact(
            'totalPersonel', 'totalKlien', 'laporanHariIni', 'insidenHariIni',
            'attendances', 'reports'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Operasional_WAS_' . Carbon::now()->format('Ymd_His') . '.pdf');
    }
}