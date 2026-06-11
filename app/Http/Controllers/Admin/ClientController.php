<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\Personel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    // Menampilkan halaman daftar klien
    public function index()
    {
        $clients = Client::latest()->get();
        return view('admin.client.index', compact('clients'));
    }

    // Menampilkan form tambah klien
    public function create()
    {
        return view('admin.client.create');
    }

    // Memproses penyimpanan data klien ke database
    public function store(Request $request)
    {
        // 1. Validasi inputan
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'lokasi_penjagaan' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Gunakan DB Transaction agar jika satu gagal, gagal semua (aman dari data gantung)
        DB::beginTransaction();

        try {
            // 2. Buat akun untuk Klien agar nanti bisa login ke portal mereka
            $user = User::create([
                'name' => $validated['nama_perusahaan'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'klien',
            ]);

            // 3. Simpan data lokasi penjagaannya
            Client::create([
                'user_id' => $user->id,
                'nama_perusahaan' => $validated['nama_perusahaan'],
                'lokasi_penjagaan' => $validated['lokasi_penjagaan'],
                'alamat_lengkap' => $validated['alamat_lengkap'],
            ]);

            DB::commit();
            return redirect()->route('admin.client.index')->with('success', 'Data Lokasi dan Akun Klien berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    // Menampilkan halaman detail lokasi dan kelola personel
    public function show($id)
    {
        $client = Client::with('personels')->findOrFail($id);
        
        // Ambil data personel yang sedang "nganggur" (belum diplot ke lokasi manapun)
        $availablePersonels = Personel::whereNull('client_id')->get();
        
        return view('admin.client.show', compact('client', 'availablePersonels'));
    }

    // Memproses plotting / penugasan personel ke lokasi ini
    public function assignPersonel(Request $request, $id)
    {
        $request->validate([
            'personel_id' => 'required|exists:personels,id'
        ]);

        $personel = Personel::findOrFail($request->personel_id);
        $personel->update(['client_id' => $id]);

        return back()->with('success', 'Personel ' . $personel->nama_lengkap . ' berhasil ditugaskan ke lokasi ini.');
    }

    // Menarik/Mencopot personel dari lokasi ini
    public function removePersonel($id, $personel_id)
    {
        $personel = Personel::findOrFail($personel_id);
        $personel->update(['client_id' => null]); // Cabut status penugasannya

        return back()->with('success', 'Personel berhasil ditarik dari penugasan.');
    }
}