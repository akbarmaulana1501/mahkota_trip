<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\Komentar;
use App\Models\Paket;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;

class IndexController extends Controller
{
    public function index()
    {
        $pesans = Komentar::latest()->get();
        $paket = Paket::withCount('jamaah')->get();
        $pekerjaan = Pekerjaan::all();

        $paketGrouped = $paket->groupBy('nama_paket');

        return view('index2', compact(
            'pesans',
            'paket',
            'pekerjaan',
            'paketGrouped'
        ));
    }


    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'required|string|max:100',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',

            'foto_ktp' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_ktp_sudah' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_kk' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_kk_sudah' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_nikah' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_paspor_sudah' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'bukti_bayar_dp' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // 2. Upload file
        // $fotoKtp = $request->file('foto_ktp')?->store('uploads/ktp', 'public');
        // $fotoKk = $request->file('foto_kk')?->store('uploads/kk', 'public');
        // $fotoPaspor = $request->file('foto_paspor')?->store('uploads/paspor', 'public');

        $fotoKtp = null;
        $fotoKk = null;
        $fotoNikah = null;
        $fotoPaspor = null;

        if ($request->status_passport === 'belum') {
            $fotoKtp = $request->file('foto_ktp')?->store('uploads/ktp', 'public');
            $fotoKk  = $request->file('foto_kk')?->store('uploads/kk', 'public');
            $fotoNikah = $request->file('foto_nikah')?->store('uploads/foto_nikah', 'public');
        }

        if ($request->status_passport === 'sudah') {
            $fotoKtp = $request->file('foto_ktp_sudah')?->store('uploads/ktp', 'public');
            $fotoKk  = $request->file('foto_kk_sudah')?->store('uploads/kk', 'public');
            $fotoPaspor = $request->file('foto_paspor_sudah')?->store('uploads/paspor', 'public');
        }

        $buktiDp = $request->file('bukti_bayar_dp')?->store('uploads/pembayaran', 'public');

        // 3. Simpan ke database
        Jamaah::create([
            'paket_id' => $request->id_paket,
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'nama_ayah' => $request->nama_ayah,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' =>$request->tempat_lahir,
            'kebangsaan' => $request->kebangsaan,
            'email' => $request->email,
            'alamat_lengkap' => $request->alamat_lengkap,
            'kontak_darurat_nama' => $request->kontak_darurat_nama,
            'kontak_darurat_hp' => $request->kontak_darurat_hp,
            'paket' => $request->paket_terpilih2,
            'nominal' => $request->nominal,
            'harga_paket' => $request->paket_harga,
            'status_pernikahan'=>$request->status_pernikahan,
            'pekerjaan'=>$request->pekerjaan,
            'pendidikan'=>$request->pendidikan,
            'status_passport' => $request->status_passport,
            'no_ktp' => $request->no_ktp,
            'foto_ktp' => $fotoKtp,
            'foto_kk' => $fotoKk,
            'foto_paspor' => $fotoPaspor,
            'foto_nikah' => $fotoNikah,
            'no_pasport'=>$request->no_passport,
            'tgl_keberangkatan'=>$request->tanggal_umroh_private,
            'status_vaksin_meningitis' => $request->status_vaksin_meningitis,
            'tgl_vaksin' => $request->tgl_vaksin,

            'bukti_bayar_dp' => $buktiDp,
            'status_validasi' => 0,
        ]);

        // ==================================
        // 4. KIRIM WHATSAPP OTOMATIS (FONNTE)
        // ==================================
        if ($request->kontak_darurat_nama) {

            $token  = env('FONTE_TOKEN');
            $target = preg_replace('/^0/', '62', $request->kontak_darurat_nama);

            $pesan = "Assalamu’alaikum {$request->nama_depan},\n\n"
                . "Anda telah *terdaftar sebagai jamaah Umroh/Haji di Mahkota Trip*.\n\n"
                . "Silakan segera melakukan *pelunasan pembayaran* agar proses keberangkatan dapat segera dilakukan.\n\n"
                . "Terima kasih 🙏";

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [
                    'target' => $target,
                    'message' => $pesan,
                    'delay' => '2',
                ],
                CURLOPT_HTTPHEADER => [
                    "Authorization: $token"
                ],
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error_msg = curl_error($curl);
            curl_close($curl);

            if ($error_msg || $httpCode != 200) {
                Log::error('Gagal kirim WhatsApp Fonnte', [
                    'target' => $target,
                    'response' => $response,
                    'error' => $error_msg
                ]);
            }
        }

        // 5. Redirect
        return redirect()->back()->with(
            'success',
            'Pendaftaran berhasil. Notifikasi WhatsApp telah dikirim.'
        );
    }


    public function scanDocument(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120',
            'type' => 'required|string|in:ktp,kk,ijazah'
        ]);

        $file = $request->file('file');
        $path = $file->store('temp/ocr', 'public');

        // full path ke file untuk diproses OCR
        $fullPath = storage_path('app/public/' . $path);

        try {
            $text = (new TesseractOCR($fullPath))
                ->lang('ind') // bahasa Indonesia
                ->run();

            // Analisis teks sesuai tipe dokumen
            $data = [];
            if ($request->type == 'ktp') {
                // Contoh sederhana: regex KTP
                if (preg_match('/\b\d{16}\b/', $text, $nik)) {
                    $data['nik'] = $nik[0];
                }
                // Nama lengkap (asumsi baris dengan "Nama")
                if (preg_match('/Nama\s*:\s*(.+)/i', $text, $nama)) {
                    $data['nama'] = trim($nama[1]);
                }
                // TTL (Tempat/Tgl Lahir)
                if (preg_match('/Tempat\s*\/\s*Tanggal\s*Lahir\s*:\s*(.+)/i', $text, $ttl)) {
                    $data['ttl'] = trim($ttl[1]);
                }
                // Alamat
                if (preg_match('/Alamat\s*:\s*(.+)/i', $text, $alamat)) {
                    $data['alamat'] = trim($alamat[1]);
                }
            } elseif ($request->type == 'kk') {
                // Contoh: ambil NKK
                if (preg_match('/\b\d{16}\b/', $text, $nkk)) {
                    $data['nkk'] = $nkk[0];
                }
            } elseif ($request->type == 'ijazah') {
                // Contoh: ambil nomor ijazah
                if (preg_match('/Nomor\s*:\s*(.+)/i', $text, $nomor)) {
                    $data['nomor'] = trim($nomor[1]);
                }
            }

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membaca dokumen: ' . $e->getMessage()
            ]);
        } finally {
            // Hapus file sementara
            Storage::disk('public')->delete($path);
        }
    }

    public function pesan_kesan(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Simpan ke database
        Komentar::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
            'rating' => $request->rating,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success_komentar', 'Terima kasih atas komentar dan rating Anda!');
    }
}
