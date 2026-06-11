<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Personel;
use App\Models\Client;
use App\Models\Report;
use App\Models\Attendance;
use Carbon\Carbon;

class DashboardExport implements FromView, ShouldAutoSize
{
    public function view(): View
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

        return view('admin.excel_dashboard', [
            'totalPersonel' => $totalPersonel,
            'totalKlien' => $totalKlien,
            'laporanHariIni' => $laporanHariIni,
            'insidenHariIni' => $insidenHariIni,
            'attendances' => $attendances,
            'reports' => $reports,
        ]);
    }
}
