<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personel;
use App\Models\User;
use App\Models\Client; // Tambahkan ini untuk memanggil model Client
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PersonelController extends Controller
{
public function index(Request $request)
    {
        // Mulai query dengan memanggil relasi user (untuk email) dan client (untuk status)
        $query = Personel::with(['user', 'client']);

        // 1. Logika Pencarian (Berdasarkan Nama atau NIP)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%');
            });
        }

        // 2. Logika Filter Status (Aktif/Ditugaskan atau Standby)
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'aktif') {
                $query->whereNotNull('client_id'); // Jika ada client_id berarti aktif ditugaskan
            } elseif ($request->status == 'standby') {
                $query->whereNull('client_id'); // Jika client_id kosong berarti standby
            }
        }

        // Ambil data terbaru
        $personels = $query->latest()->get();

        return view('admin.personel.index', compact('personels'));
    }

    public function create()
    {
        // Ambil semua data klien/lokasi untuk ditampilkan di dropdown form
        $clients = Client::all();
        return view('admin.personel.create', compact('clients'));
    }

public function store(Request $request)
{
    // 1. Validasi semua input yang ada di form kamu
    $validated = $request->validate([
        'nip' => 'required|string|unique:personels,nip',
        'nama_lengkap' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'no_hp' => 'required|string',
        'alamat' => 'nullable|string',
        'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    DB::beginTransaction();

    try {
        // 2. Buat akun User
        $user = User::create([
            'name' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'personel',
        ]);

        if ($request->hasFile('foto_profil')) {
            $fotoFile = $request->file('foto_profil');
            $fotoNama = time() . '_avatar_' . $user->id . '.' . $fotoFile->getClientOriginalExtension();
            $fotoFile->storeAs('avatars', $fotoNama, 'public');
            $user->update(['foto_profil' => 'avatars/' . $fotoNama]);
        }

        // 3. Simpan Profil Personel (Hubungkan semua fieldnya)
        Personel::create([
            'user_id' => $user->id,
            'client_id' => null, // Tetap null sesuai alur plotting kita
            'nip' => $validated['nip'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'] ?? '-',
        ]);

        DB::commit();
        return redirect()->route('admin.personel.index')->with('success', 'Data Personel berhasil disimpan.');

    } catch (\Exception $e) {
        DB::rollback();
        // Menampilkan pesan error asli jika terjadi kegagalan sistem
        return back()->withErrors(['error' => 'Gagal: ' . $e->getMessage()])->withInput();
    }
}

// 1. Menampilkan Halaman Edit
    public function edit($id)
    {
        $personel = \App\Models\Personel::with('user')->findOrFail($id);
        $clients = \App\Models\Client::orderBy('nama_perusahaan', 'asc')->get();
        
        return view('admin.personel.edit', compact('personel', 'clients'));
    }

    // 2. Memproses Perubahan Data (Update)
    public function update(Request $request, $id)
    {
        $personel = \App\Models\Personel::findOrFail($id);
        $user = $personel->user;

        $request->validate([
            'nip' => 'required|string|unique:personels,nip,'.$personel->id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6', // Password opsional saat edit
            'client_id' => 'nullable|exists:clients,id',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data User (Akun Login)
        $user->name = $request->nama_lengkap;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
            }
            $fotoFile = $request->file('foto_profil');
            $fotoNama = time() . '_avatar_' . $user->id . '.' . $fotoFile->getClientOriginalExtension();
            $fotoFile->storeAs('avatars', $fotoNama, 'public');
            $user->foto_profil = 'avatars/' . $fotoNama;
        }

        $user->save();

        // Update data Personel
        $personel->update([
            'nip' => $request->nip,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'client_id' => $request->client_id,
        ]);

        return redirect()->route('admin.personel.index')->with('success', 'Data personel berhasil diperbarui!');
    }

// 3. Menghapus Data (Delete)
    public function destroy($id)
    {
        $personel = \App\Models\Personel::findOrFail($id);
        
        // PROTEKSI: Cegah admin menghapus akunnya sendiri
        if ($personel->user_id == \Illuminate\Support\Facades\Auth::id()) {
            return redirect()->back()->withErrors('Aksi Ditolak: Anda tidak bisa menghapus data personel yang terhubung dengan akun Anda sendiri saat ini.');
        }

        // Hapus akun user-nya terlebih dahulu (jika ada)
        if ($personel->user) {
            if ($personel->user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($personel->user->foto_profil)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($personel->user->foto_profil);
            }
            $personel->user->delete(); 
        } 
        
        // Hapus data personelnya
        $personel->delete();

        return redirect()->route('admin.personel.index')->with('success', 'Data personel dan akses loginnya berhasil dihapus permanen!');
    }

}