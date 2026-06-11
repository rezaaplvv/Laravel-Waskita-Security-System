<?php

namespace App\Http\Controllers\Klien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Personel;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data Klien berdasarkan Akun yang login
        $client = Client::where('user_id', Auth::id())->first();

        // Jika belum ada relasi/data, lempar ke view kosong
        if (!$client) {
            return view('klien.dashboard', ['error' => 'Data profil perusahaan Anda belum diatur oleh Admin Pusat.']);
        }

        $today = Carbon::today();

        // 2. Ambil Personel yang ditugaskan (di-plotting) ke Klien ini
        $personelBertugas = Personel::where('client_id', $client->id)->get();
        $totalPersonel = $personelBertugas->count();

        // 3. Kalkulasi Laporan Hari Ini
        $laporanHariIni = Report::where('client_id', $client->id)
                                ->whereDate('created_at', $today)
                                ->count();

        $insidenHariIni = Report::where('client_id', $client->id)
                                ->where('tipe_laporan', 'insiden')
                                ->whereDate('created_at', $today)
                                ->count();

        // Status Area Pintar
        $statusArea = ($insidenHariIni > 0) ? 'SIAGA / INSIDEN' : 'AMAN KONDUSIF';
        $statusColor = ($insidenHariIni > 0) ? 'text-red-500' : 'text-emerald-500';

        // 4. Ambil 5 Laporan Terkini untuk Live Feed
        $laporanTerkini = Report::with('personel')
                                ->where('client_id', $client->id)
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();

        return view('klien.dashboard', compact(
            'client', 
            'personelBertugas', 
            'totalPersonel', 
            'laporanHariIni', 
            'insidenHariIni',
            'statusArea',
            'statusColor',
            'laporanTerkini'
        ));
    }

    public function team()
    {
        $client = \App\Models\Client::where('user_id', Auth::id())->first();

        if (!$client) {
            return redirect()->route('klien.dashboard')->with('error', 'Data profil perusahaan belum diatur.');
        }

        // Ambil data personel beserta relasi user-nya (untuk ambil foto profil nantinya)
        $personelBertugas = \App\Models\Personel::with('user')->where('client_id', $client->id)->get();
        
        // Ambil data absensi hari ini khusus untuk personel di klien ini (untuk fitur Live Status)
        $today = \Carbon\Carbon::today()->toDateString();
        $attendances = \App\Models\Attendance::whereIn('personel_id', $personelBertugas->pluck('id'))
                                 ->where('tanggal', $today)
                                 ->get()
                                 ->keyBy('personel_id'); // Jadikan ID personel sebagai key array

        return view('klien.team', compact('client', 'personelBertugas', 'attendances'));
    }

    public function attendance()
    {
        $client = \App\Models\Client::where('user_id', Auth::id())->first();

        if (!$client) {
            return redirect()->route('klien.dashboard')->with('error', 'Data profil perusahaan belum diatur.');
        }

        // 1. Ambil semua ID personel yang ditugaskan ke klien ini
        $personelIds = \App\Models\Personel::where('client_id', $client->id)->pluck('id');

        // 2. Ambil data absensi mereka, urutkan dari tanggal terbaru
        $attendances = \App\Models\Attendance::with('personel')
                            ->whereIn('personel_id', $personelIds)
                            ->orderBy('tanggal', 'desc')
                            ->orderBy('jam_masuk', 'desc')
                            ->get();

        return view('klien.attendance', compact('client', 'attendances'));
    }
    public function report(Request $request)
    {
        $client = \App\Models\Client::where('user_id', Auth::id())->first();

        if (!$client) {
            return redirect()->route('klien.dashboard')->with('error', 'Data profil perusahaan belum diatur.');
        }

        // Fitur Filter Tipe Laporan (Semua, Patroli, atau Insiden)
        $query = \App\Models\Report::with('personel')
                                   ->where('client_id', $client->id);

        if ($request->has('tipe') && in_array($request->tipe, ['patroli', 'insiden'])) {
            $query->where('tipe_laporan', $request->tipe);
        }

        $reports = $query->orderBy('created_at', 'desc')->get();

        return view('klien.report', compact('client', 'reports'));
    }
}