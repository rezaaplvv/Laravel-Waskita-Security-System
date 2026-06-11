<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Mengambil semua laporan dari database, beserta relasi data personel dan klien
        $reports = Report::with(['personel', 'client'])->latest()->get();
        
        return view('admin.report.index', compact('reports'));
    }
}