<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SAdminController extends Controller
{
    public function index()
    {
        return view('superadmin.dashboard');
    }

    public function validasi_pengeluaran($id)
    {
        $data = Pengeluaran::findOrFail($id);

        $data->update([
            'validation_by' => Auth::user()->username,
            'validation_at' => now()
        ]);

        // generate ulang PDF
        $pdf = Pdf::loadView('admin.utama.pengeluaran.pengajuan_pdf', ['pengeluaran' => $data]);

        $filename = 'pengeluaran_' . $data->id . '.pdf';

        Storage::put('public/pengeluaran/' . $filename, $pdf->output());

        $data->update([
            'bukti' => 'pengeluaran/' . $filename
        ]);

        logActivity(
            'update',
            'Pengeluaran',
            $data->id,
            'Data pengeluaran berhasil dverifikasi!'
        );

        return back()->with('success_verified', 'Pengeluaran berhasil diverifikasi');
    }
}
