<?php

namespace App\Http\Controllers;

use App\Models\BuktiPenyerahan;
use App\Models\DistribusiLogistik;
use App\Models\Jamaah;
use App\Models\Logistik;
use App\Models\Penyerahan;
use Illuminate\Http\Request;

class LogistikController extends Controller
{
    public function index()
    {
        $logistik_sudah = Jamaah::where('status_logistik', 1)->get()->count();
        $logistik_belum = Jamaah::where('status_logistik', 0)->get()->count();
        return view('admin.logistik.dashboard', compact('logistik_sudah', 'logistik_belum'));
    }

    // public function tampil_data_distribusi()
    // {
    //     $jamaah_logistik = Jamaah::with([
    //         'penyerahan.distribusiLogistik.logistik'
    //     ])->get();
    //     $logistik = Logistik::all();
    //     return view('admin.logistik.distribusi_logistik.tampil_data', compact('jamaah_logistik', 'logistik'));
    // }

    public function tampil_data_distribusi(Request $request)
    {
        $query = Jamaah::with([
            'penyerahan.distribusiLogistik.logistik'
        ]);

        // Filter berdasarkan status
        if ($request->status == 'belum') {
            $query->whereDoesntHave('penyerahan.distribusiLogistik');
        } elseif ($request->status == 'sudah') {
            $query->whereHas('penyerahan.distribusiLogistik');
        }

        $jamaah_logistik = $query->get();
        $logistik = Logistik::all();

        return view('admin.logistik.distribusi_logistik.tampil_data', compact('jamaah_logistik', 'logistik'));
    }

    public function serahkanLogistik(Request $request)
    {
        $request->validate([
            'barang' => 'required|array',
            'bukti_penyerahan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $buktiPath = null;

        // Upload bukti jika ada
        if ($request->hasFile('bukti_penyerahan')) {
            $buktiPath = $request->file('bukti_penyerahan')
                ->store('bukti_penyerahan', 'public');
        }

        // buat data penyerahan dulu
        $penyerahan = Penyerahan::create([
            'jamaah_id' => $request->jamaah_id,
            'tanggal_penyerahan' => now(),
            'bukti_penyerahan' => $buktiPath,
            'user_id' => auth()->id(),
            'status' => 1
        ]);

        // simpan barang logistik
        foreach ($request->barang as $barangId) {

            DistribusiLogistik::create([
                'penyerahan_id' => $penyerahan->id,
                'logistik_id' => $barangId
            ]);
        }

        return redirect()->back()
            ->with('success_serahkan', 'Logistik berhasil diserahkan');
    }
}
