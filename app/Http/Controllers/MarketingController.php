<?php

namespace App\Http\Controllers;

use App\Models\CalonJamaah;
use App\Models\Jamaah;
use App\Models\Komisi;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketingController extends Controller
{
    protected $dir = 'admin.marketing';

    public function index()
    {
        $user = auth()->user();

        // Total pendaftar
        $total_mendaftar = CalonJamaah::where('referral_code', $user->referral_code)->count();

        // Total semua komisi milik user
        $total_komisi = Komisi::where('marketing_id', $user->referral_code)
            ->where('status', 1)
            ->sum('nominal_komisi');

        // Komisi bulan ini
        $total_komisi_bulan_ini = Komisi::where('marketing_id', $user->referral_code)
            ->where('status', 1)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('nominal_komisi');

        // Komisi pending
        $komisi_pending = Komisi::where('marketing_id', $user->referral_code)
            ->where('status', 0)
            ->sum('nominal_komisi');

        // Komisi cair
        $komisi_cair = Komisi::where('marketing_id', $user->referral_code)
            ->where('status', 1)
            ->sum('nominal_komisi');

        return view('admin.marketing.dashboard', compact(
            'total_mendaftar',
            'total_komisi',
            'total_komisi_bulan_ini',
            'komisi_pending',
            'komisi_cair'
        ));
    }

    public function calon_jamaah()
    {
        $calon_jamaah = CalonJamaah::with('paket')
            ->where('referral_code', auth()->user()->referral_code)
            ->get();

        return view($this->dir . '.calon_jamaah.tampil_data', compact('calon_jamaah'));
    }

    public function daftar_calon_jamaah(Request $request)
    {
        $paket = Paket::all();
        $referral = $request->query('ref');

        return view(
            $this->dir . '.calon_jamaah.tambah_data',
            compact('paket', 'referral')
        );
    }

    public function store_calon_jamaah(Request $request)
    {
        // 1️⃣ Validasi input
        $validated = $request->validate([
            'nama_jamaah'     => 'required|string|max:255',
            'jenis_kelamin'   => 'required|in:L,P',
            'no_hp'           => 'required|digits_between:10,13',
            'email'           => 'nullable|email',
            'alamat_lengkap'  => 'nullable|string',
            'kode_referral'   => 'nullable|string', // tambahkan agar valid
        ]);

        // 2️⃣ Ambil referral dan marketing
        $referralCode = $validated['kode_referral']; // <--- DISINI
        $marketing = null;
        if ($referralCode) {
            $marketing = User::where('referral_code', $referralCode)->first();
        }

        // 3️⃣ Simpan calon jamaah
        CalonJamaah::create([
            'nama_jamaah'     => $validated['nama_jamaah'],
            'jenis_kelamin'   => $validated['jenis_kelamin'],
            'no_hp'           => $validated['no_hp'],
            'email'           => $validated['email'] ?? null,
            'alamat_lengkap'  => $validated['alamat_lengkap'] ?? null,
            'paket_diminati'  => $request->paket_id,
            'status'          => 0,
            'referral_code'   => $referralCode,
            'sumber_daftar'   => $marketing ? 'marketing' : 'langsung',
        ]);

        // 4️⃣ Opsional: bonus marketing
        // if ($marketing) {
        //     $marketing->increment('bonus', 1);
        // }

        // 5️⃣ Redirect sukses
        return redirect()->back()->with('success', 'Calon jamaah berhasil disimpan!');
    }


    public function edit_data_calon_jamaah($id)
    {
        $calon_jamaah = CalonJamaah::findOrFail($id);
        $paket = Paket::all();
        return view($this->dir . '.calon_jamaah.edit_data', compact('calon_jamaah', 'paket'));
    }

    public function update_calon_jamaah(Request $request, $id)
    {
        $request->validate([
            'nama_jamaah' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|max:15',
            'email' => 'nullable|email',
            'alamat_lengkap' => 'required',
            'paket_id' => 'required',
            'kode_referral' => 'nullable'
        ]);

        $calon_jamaah = CalonJamaah::findOrFail($id);

        $calon_jamaah->update([
            'nama_jamaah' => $request->nama_jamaah,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat_lengkap' => $request->alamat_lengkap,
            'paket_diminati' => $request->paket_id,
            'kode_referral' => $request->kode_referral
        ]);

        return redirect()->route('calonjamaah.index')->with('success_update', 'Data berhasil diupdate');
    }

    public function validasi($id)
    {
        DB::beginTransaction();

        try {
            $calon = CalonJamaah::findOrFail($id);

            // ❗ Cegah double validasi
            if ($calon->status == 1) {
                return response()->json([
                    'message' => 'Jamaah sudah divalidasi sebelumnya'
                ], 400);
            }

            // Update status
            $calon->update([
                'status' => 1
            ]);

            // Split nama
            $nama = explode(' ', $calon->nama_jamaah);
            $namaDepan = array_shift($nama);
            $namaBelakang = implode(' ', $nama);

            // Insert jamaah
            $jamaah = Jamaah::create([
                'nama_depan'    => $namaDepan,
                'nama_belakang' => $namaBelakang,
                'jenis_kelamin' => $calon->jenis_kelamin,
                'no_hp'         => $calon->no_hp,
                'email'         => $calon->email,
                'alamat_lengkap' => $calon->alamat_lengkap,
                'paket_id'      => $calon->paket_diminati,
            ]);

            // Hitung komisi
            $komisiNominal = $calon->paket->harga * 0.1; // contoh

            // Insert komisi
            Komisi::create([
                'jamaah_id'      => $jamaah->id,
                'marketing_id'   => $calon->referral_code, // lebih aman
                'nominal_komisi' => $komisiNominal,
                'status'         => 0
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Jamaah berhasil divalidasi & komisi dibuat'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function komisi()
    {
        $komisi = Komisi::with('jamaah', 'marketing')->where('marketing_id', auth()->user()->referral_code)->get();
        return view('admin.marketing.komisi.tampil_data', compact('komisi'));
    }
}
