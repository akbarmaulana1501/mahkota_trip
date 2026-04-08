<?php

namespace App\Http\Controllers;

use App\Models\DistribusiLogistik;
use App\Models\Jamaah;
use App\Models\Komentar;
use App\Models\Komisi;
use App\Models\Log_activity;
use App\Models\Logistik;
use App\Models\Maskapai;
use App\Models\Paket;
use App\Models\Payment;
use App\Models\Pekerjaan;
use App\Models\Pemasukan;
use App\Models\Pembayaran;
use App\Models\Pembimbing;
use App\Models\Pengeluaran;
use App\Models\Penyerahan;
use App\Models\Rombongan;
use App\Models\Siskopatu;
use App\Models\TiketBerangkat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;
use PhpParser\Node\Expr\FuncCall;
use Psy\CodeCleaner\FunctionContextPass;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminUtamaController extends Controller
{
    //menu dashboard
    public function index()
    {
        $jamaah = Jamaah::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $rombongan = Rombongan::count();
        $jamaah_berangkat = Jamaah::where('status_validasi', 1)->count();
        $jamaah_sudah_berangkat = Jamaah::where('status_keberangkatan', 1)->count();
        $jamaah_belum_berangkat = Jamaah::where('status_keberangkatan', 0)->count();
        $jamaah_belum_validasi = Jamaah::where('status_validasi', 0)->count();
        $jamaah_belum_logistik = Jamaah::where('status_logistik', 0)->count();
        $total_rombongan = Jamaah::whereNotNull('id_rombongan')->count();
        $total_rombongan = Jamaah::whereNotNull('id_rombongan')
            ->distinct('id_rombongan')
            ->count('id_rombongan');

        $total_rombongan_sudah_berangkat = Jamaah::where('status_keberangkatan', 1)
            ->distinct('id_rombongan')
            ->count('id_rombongan');

        $total_rombongan_belum_berangkat = Jamaah::where('status_keberangkatan', 0)
            ->distinct('id_rombongan')
            ->count('id_rombongan');

        return view('admin.utama.dashboard', compact(
            'jamaah',
            'rombongan',
            'jamaah_berangkat',
            'jamaah_belum_validasi',
            'jamaah_sudah_berangkat',
            'jamaah_belum_berangkat',
            'jamaah_belum_logistik',
            'total_rombongan',
            'total_rombongan_sudah_berangkat',
            'total_rombongan_belum_berangkat'
        ));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah'
            ]);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('successUpdatePassword', 'Password berhasil diperbarui');
    }

    //menu manajemen user
    public function manajemen_user(Request $request)
    {
        $query = User::query()->where('role', '!=', 'developer');

        // Jika ada filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $user = $query->get();

        return view('admin.utama.manajemen_user.tampil_data', compact('user'));
    }

    public function tambah_user()
    {
        return view('admin.utama.manajemen_user.tambah_data');
    }

    public function store_user(Request $request)
    {
        // 🔍 1. Validasi data input
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'alamat'       => 'required|string|max:255',
            'no_hp' => 'required|digits:12',
        ], [
            'no_hp.digits' => 'Nomor HP harus tepat 12 digit',
        ]);

        $password_default = "123456";

        $user = new User();
        $user->username = $validated['nama_lengkap'];
        $user->email = $validated['email'];
        $user->alamat = $validated['alamat'];
        $user->password = Hash::make($password_default);
        $user->no_hp = $validated['no_hp'];
        $user->role = $request->role;
        $user->kacab = $request->kacab;

        if ($user->role === 'marketing') {
            $user->referral_code = $this->generateReferralCode();
        }
        $user->save();

        // ✅ 3. Redirect dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }

    private function generateReferralCode($prefix = 'MKT')
    {
        do {
            // Contoh hasil: MKT-8F3A2C
            $code = $prefix . '-' . strtoupper(Str::random(6));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }

    public function edit_user($id)
    {
        $user = User::findOrFail($id);
        return view('admin.utama.manajemen_user.edit_data', compact('user'));
    }


    public function destroy_user($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('deleteSuccess', 'User berhasil dihapus!');
    }

    public function update_user(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email',
            'alamat'       => 'nullable|string|max:255',
            'no_hp'        => 'nullable|numeric|digits:12',
        ]);

        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        // Update data
        $user->username = $request->nama_lengkap;
        $user->email    = $request->email;
        $user->alamat   = $request->alamat;
        $user->no_hp    = $request->no_hp;
        $user->kacab    = $request->kacab;

        // Simpan
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('user.index')->with('successUpdate', 'Data pengguna berhasil diperbarui!');
    }
    // public function tampil_jamaah()
    // {

    //     $jamaah = Jamaah::all();
    //     return view('admin.utama.manajemen_jamaah.tampil_data', compact('jamaah'));
    // }
    public function tampil_jamaah(Request $request)
    {
        $query = Jamaah::with(['pakets', 'rombongan', 'tiket', 'siskopatu']);

        if ($request->filter == 'belum') {
            $query->where('status_validasi', 0);
        } elseif ($request->filter == 'sudah') {
            $query->where('status_validasi', 1);
        }

        $jamaah = $query->get();

        return view('admin.utama.manajemen_jamaah.tampil_data', compact('jamaah'));
    }


    public function tambah_jamaah()
    {
        $paket = Paket::all();
        $pekerjaan = Pekerjaan::all();

        // Ambil id paket Umroh Private
        $umrohPrivate = Paket::where('nama_paket', 'Umroh Private')->first();
        $umrohPrivateId = $umrohPrivate ? $umrohPrivate->id : null;

        // Ambil semua tanggal keberangkatan yang sudah dibooking untuk paket Umroh Private
        $bookedDates = [];
        if ($umrohPrivateId) {
            $bookedDates = Jamaah::where('paket_id', $umrohPrivateId)
                ->whereNotNull('tgl_keberangkatan') // pastikan ada tanggal
                ->pluck('tgl_keberangkatan')
                ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
                ->toArray();
        }

        return view('admin.utama.manajemen_jamaah.tambah_data', compact('paket', 'pekerjaan', 'bookedDates'));
    }

    public function store_jamaah(Request $request)
    {
        // ========================
        // Validasi
        // ========================
        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'required|string|max:100',
            'nama_ayah' => 'required|string|max:100',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'status_pernikahan' => 'required',
            'pekerjaan' => 'required',
            'pendidikan' => 'required',
            'paket_id' => 'required|exists:pakets,id',
            'foto_ktp' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_kk' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_paspor' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_akte' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_vaksin' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // ========================
        // Upload File
        // ========================
        $fileFields = [
            'foto_ktp',
            'foto_kk',
            'foto_paspor',
            'foto_akte',
            'foto_vaksin',
        ];

        $fileData = [];

        if ($request->hasFile('foto_ktp')) {
            $fileData['foto_ktp'] = $request->file('foto_ktp')->store('uploads/ktp', 'public');
        }

        if ($request->hasFile('foto_kk')) {
            $fileData['foto_kk'] = $request->file('foto_kk')->store('uploads/kk', 'public');
        }

        if ($request->hasFile('foto_paspor')) {
            $fileData['foto_paspor'] = $request->file('foto_paspor')->store('uploads/paspor', 'public');
        }

        if ($request->hasFile('foto_akte')) {
            $fileData['foto_akte'] = $request->file('foto_akte')->store('uploads/akte', 'public');
        }

        if ($request->hasFile('foto_vaksin')) {
            $fileData['foto_vaksin'] = $request->file('foto_vaksin')->store('uploads/vaksin', 'public');
        }

        // ========================
        // Ambil data paket
        // ========================
        $paket = Paket::findOrFail($request->paket_id);

        // ========================
        // Simpan ke database
        // ========================
        $jamaah = Jamaah::create(array_merge([
            // Data Pribadi
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'nama_ayah' => $request->nama_ayah,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'status_pernikahan' => $request->status_pernikahan,
            'pekerjaan' => $request->pekerjaan,
            'pendidikan' => $request->pendidikan,
            'email' => $request->email,
            'alamat_lengkap' => $request->alamat_lengkap,
            'kontak_darurat_nama' => $request->kontak_darurat_nama,
            'kontak_darurat_hp' => $request->kontak_darurat_hp,

            // Paket
            'paket_id' => $request->paket_id,
            'paket' => $paket->nama_paket,
            'harga_paket' => $paket->harga_paket,
            'tgl_keberangkatan' => $request->tgl_keberangkatan,

            // Passport
            'status_passport' => $request->status_passport,
            'no_ktp' => $request->no_ktp,
            'no_pasport' => $request->no_paspor,
            'tgl_terbit' => $request->tgl_terbit,
            'tgl_exp' => $request->tgl_exp,
            'daerah_terbit' => $request->daerah_penerbitan,

            // Vaksinasi
            'status_vaksin_meningitis' => $request->status_vaksin_meningitis,
        ], $fileData)); // gabungkan data file jika ada

        $pengeluaran = Pengeluaran::create([
            'item' => 'Pembayaran Visa Untuk Jamaah dengan nama ' . $jamaah->nama_depan . ' ' . $jamaah->nama_belakang,
            'kuantiti' => '1',
            'satuan' => 'Jamaah',
            'created_by' => Auth::user()->username
        ]);

        logActivity(
            'create',
            'Jamaah',
            $jamaah->id,
            'Data jamaah ' . $jamaah->nama_depan . ' ' . $jamaah->nama_belakang . ' berhasil ditambahkan!'
        );

        logActivity(
            'create',
            'Pengeluaran',
            $pengeluaran->id,
            'Menambahkan pengeluaran untuk : ' . $pengeluaran->item
        );

        return redirect()->route('jamaah.index')->with('success', 'Data jamaah berhasil disimpan.');
    }

    public function edit_jamaah($id)
    {
        $jamaah = Jamaah::findOrFail($id);
        $pekerjaan = Pekerjaan::all();
        $paket = Paket::all();
        $gateway = DB::table('payments')
            ->where('user_id', $id)
            ->selectRaw("
        'gateway' as sumber,
        amount,
        status,
        NULL as bukti_pembayaran,
        created_at as waktu
        ");

        $manual = DB::table('pembayarans')
            ->where('user_id', $id)
            ->selectRaw("
        'manual' as sumber,
        amount,
        status,
        bukti_pembayaran,
        created_at as waktu
    ");

        $riwayat_pembayaran = DB::query()
            ->fromSub($gateway->unionAll($manual), 'riwayat')
            ->orderByDesc('waktu')
            ->get();
        return view('admin.utama.manajemen_jamaah.edit_data', compact('jamaah', 'paket', 'riwayat_pembayaran', 'pekerjaan'));
    }

    public function store_pembayaran_jamaah(Request $request)
    {
        DB::transaction(function () use ($request) {

            // ======================
            // HITUNG ANGSURAN KE BERAPA
            // ======================
            $jumlahPembayaranSebelumnya = Pembayaran::where('user_id', $request->jamaah_id)->count();

            $angsuranKe = $jumlahPembayaranSebelumnya + 1;

            // ======================
            // UPLOAD FILE
            // ======================
            $file = $request->file('bukti_pembayaran');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_pembayaran', $namaFile, 'public');

            // ======================
            // INSERT KE TABEL PEMBAYARAN
            // ======================
            $pembayaran = Pembayaran::create([
                'user_id' => $request->jamaah_id,
                'amount' => $request->amount,
                'status' => 'paid',
                'bukti_pembayaran' => $path
            ]);

            // ======================
            // INSERT KE TABEL PEMASUKAN
            // ======================
            DB::table('pemasukans')->insert([
                'id_jamaah'   => $request->jamaah_id,
                'jumlah'      => $request->amount,
                'keterangan'  => 'Pembayaran Jamaah',
                'angsuran_ke' => $angsuranKe, // 🔥 INI YANG BENAR
                'bukti'       => $path,
                'status'      => 'Paid',
                'created_by'  => Auth::user()->username,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            logActivity(
                'approve',
                'Pembayaran',
                $pembayaran->id,
                'Menyetujui pembayaran sebesar Rp ' . number_format($request->amount, 0, ',', '.')
            );
        });


        return back()->with('success_pembayaran_cicilan', 'Pembayaran berhasil ditambahkan');
    }

    public function update_jamaah(Request $request, $id)
    {
        $jamaah = Jamaah::findOrFail($id);

        // =========================
        // Handle File Upload
        // =========================
        $fileFields = [
            'foto_ktp',
            'foto_kk',
            'foto_paspor',
            'foto_akte',
            'foto_vaksin',
        ];

        $fileData = [];

        if ($request->hasFile('foto_ktp')) {
            $fileData['foto_ktp'] = $request->file('foto_ktp')->store('uploads/ktp', 'public');
        }

        if ($request->hasFile('foto_kk')) {
            $fileData['foto_kk'] = $request->file('foto_kk')->store('uploads/kk', 'public');
        }

        if ($request->hasFile('foto_paspor')) {
            $fileData['foto_paspor'] = $request->file('foto_paspor')->store('uploads/paspor', 'public');
        }

        if ($request->hasFile('foto_akte')) {
            $fileData['foto_akte'] = $request->file('foto_akte')->store('uploads/akte', 'public');
        }

        if ($request->hasFile('foto_vaksin')) {
            $fileData['foto_vaksin'] = $request->file('foto_vaksin')->store('uploads/vaksin', 'public');
        }

        // =========================
        // Update Data Jamaah
        // =========================
        $jamaah->update(array_merge([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'nama_ayah' => $request->nama_ayah,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'status_pernikahan' => $request->status_pernikahan,
            'pekerjaan' => $request->pekerjaan,
            'pendidikan' => $request->pendidikan,
            'email' => $request->email,
            'alamat_lengkap' => $request->alamat_lengkap,
            'kontak_darurat_nama' => $request->kontak_darurat_nama,
            'kontak_darurat_hp' => $request->kontak_darurat_hp,
            'paket_id' => $request->paket_id,
            'status_passport' => $request->status_passport,
            'no_ktp' => $request->no_ktp,
            'no_pasport' => $request->no_paspor,
            'tgl_terbit' => $request->tgl_terbit,
            'tgl_exp' => $request->tgl_exp,
            'daerah_terbit' => $request->daerah_penerbitan,
            'status_vaksin_meningitis' => $request->status_vaksin_meningitis,
            'tgl_keberangkatan' => $request->tgl_keberangkatan
        ], $fileData)); // gabungkan data file jika ada

        logActivity(
            'update',
            'Jamaah',
            $jamaah->id,
            'Data jamaah ' . $jamaah->nama_depan . ' ' . $jamaah->nama_belakang . ' berhasil diperbarui'
        );

        return redirect()->route('jamaah.index')->with('success_update', 'Data jamaah berhasil diperbarui');
    }

    public function destroy_jamaah($id)
    {
        $jamaah = Jamaah::findOrFail($id);

        if ($jamaah->foto_ktp) \Illuminate\Support\Facades\Storage::disk('public')->delete($jamaah->foto_ktp);
        if ($jamaah->foto_kk) \Illuminate\Support\Facades\Storage::disk('public')->delete($jamaah->foto_kk);
        if ($jamaah->foto_paspor) \Illuminate\Support\Facades\Storage::disk('public')->delete($jamaah->foto_paspor);
        if ($jamaah->bukti_bayar_dp) \Illuminate\Support\Facades\Storage::disk('public')->delete($jamaah->bukti_bayar_dp);

        $jamaah->delete();

        return redirect()->route('jamaah.index')->with('success_hapus_jamaah', 'Data jamaah berhasil dihapus.');
    }

    public function validasi_jamaah($id)
    {
        $jamaah = Jamaah::with(['payments', 'pembayarans', 'pakets'])->findOrFail($id);

        // =========================
        // CEK BERKAS LENGKAP
        // =========================
        $ktp = $jamaah->foto_ktp ?? null;
        $kk = $jamaah->foto_kk ?? null;
        $paspor = $jamaah->foto_paspor ?? null;

        $berkasLengkap = $ktp && $kk && $paspor;

        if (!$berkasLengkap) {
            return redirect()->back()->with('error_berkas', 'Berkas jamaah belum lengkap!');
        }

        // =========================
        // CEK PEMBAYARAN
        // =========================
        $totalUser = $jamaah->payments()->sum('amount');
        $totalAdmin = $jamaah->pembayarans()->sum('amount');

        $terbayar = $totalUser + $totalAdmin;
        $target = $jamaah->pakets->harga_paket ?? 0;

        if ($terbayar < $target) {
            return redirect()->back()->with('error_pembayaran', 'Pembayaran jamaah belum lunas!');
        }

        // =========================
        // VALIDASI
        // =========================
        $jamaah->status_validasi = 1;
        $jamaah->save();

        // =========================
        // INSERT KE SISKOPATU
        // =========================
        Siskopatu::updateOrCreate(
            ['id_jamaah' => $jamaah->id], // 🔍 kondisi cari
            [ // ✏️ data yang diisi / update
                'nama_lengkap'     => $jamaah->nama_depan . ' ' . $jamaah->nama_belakang,
                'nama_ayah'        => $jamaah->nama_ayah ?? null,
                'jenis_identitas'  => 'KTP',
                'no_identitas'     => $jamaah->no_ktp,
                'nama_paspor'      => $jamaah->nama_paspor ?? $jamaah->nama_depan . ' ' . $jamaah->nama_belakang,
                'no_paspor'        => $jamaah->no_paspor ?? null,
                'tgl_paspor'       => $jamaah->tgl_paspor ?? null,
                'kota_paspor'      => $jamaah->kota_paspor ?? null,
                'tempat_lahir'     => $jamaah->tempat_lahir,
                'tanggal_lahir'    => $jamaah->tanggal_lahir,
                'alamat_lengkap'   => $jamaah->alamat_lengkap,
                'provinsi'         => $jamaah->provinsi ?? null,
                'kabupaten'        => $jamaah->kabupaten ?? null,
                'kecamatan'        => $jamaah->kecamatan ?? null,
                'kelurahan'        => $jamaah->kelurahan ?? null,
                'no_telepon'       => $jamaah->no_telepon ?? null,
                'no_hp'            => $jamaah->no_hp ?? null,
                'kewarganegaraan'  => $jamaah->kewarganegaraan ?? 'Indonesia',
                'status_pernikahan' => $jamaah->status_pernikahan ?? null,
                'pendidikan'       => $jamaah->pendidikan ?? null,
                'pekerjaan'        => $jamaah->pekerjaan ?? null,
                'pekerjaan_lainnya' => $jamaah->pekerjaan_lainnya ?? null,
                'provider_visa'    => null,
                'no_visa'          => null,
                'tgl_berlaku_visa' => null,
                'tgl_akhir_visa'   => null,
                'asuransi'         => null,
                'no_polis'         => null,
                'tgl_input_polis'  => null,
                'tgl_awal_polis'   => null,
                'tgl_akhir_polis'  => null,
                'no_bpjs'          => null,
            ]
        );

        logActivity(
            'update',
            'Jamaah',
            $jamaah->id,
            'jamaah dengan nama ' . $jamaah->nama_depan . ' ' . $jamaah->nama_belakang . ' berhasil diValidasi!'
        );

        logActivity(
            'create',
            'Siskopatuh',
            $jamaah->id,
            'jamaah dengan nama ' . $jamaah->nama_depan . ' ' . $jamaah->nama_belakang . ' berhasil diinput ke dalam Siskopatuh!'
        );

        return redirect()->back()->with('success_validasi', 'Status validasi berhasil diupdate!');
    }

    public function unvalidate_jamaah($id)
    {
        $jamaah = Jamaah::findOrFail($id);

        // Update status_validasi menjadi 1
        $jamaah->status_validasi = 0;
        $jamaah->save();

        logActivity(
            'delete',
            'Jamaah',
            $jamaah->id,
            'jamaah dengan nama ' . $jamaah->nama_depan . ' ' . $jamaah->nama_belakang . ' berhasil dihapus!'
        );

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success_unvalidate', 'Jamaah berhasil dihapus!');
    }

    public function manajemen_paket()
    {
        $paket = Paket::withCount('jamaah')->get();
        return view('admin.utama.manajemen_paket.tampil_data', compact('paket'));
    }

    public function tambah_paket()
    {
        $maskapai = Maskapai::all();
        return view('admin.utama.manajemen_paket.tambah_data', compact('maskapai'));
    }

    public function store_paket(Request $request)
    {
        $request->validate([
            'nama_paket'      => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'harga'           => 'required'
        ]);

        $lokasiMekkah = $request->lat_mekkah && $request->lng_mekkah
            ? $request->lat_mekkah . ',' . $request->lng_mekkah
            : null;

        $lokasiMadinah = $request->lat_madinah && $request->lng_madinah
            ? $request->lat_madinah . ',' . $request->lng_madinah
            : null;

        Paket::create([
            'nama_paket'        => $request->nama_paket,
            'jenis_paket'       => $request->jenis_paket,
            'tgl_berangkat'     => $request->tanggal_berangkat,
            'kuota'             => $request->kuota,
            'hotel_mekkah'      => $request->hotel_mekkah,
            'hotel_madinah'     => $request->hotel_madinah,
            'lokasi_mekkah'     => $lokasiMekkah,   // 👈 hasil gabungan
            'lokasi_madinah'    => $lokasiMadinah,  // 👈 hasil gabungan
            'harga_paket'       => str_replace(['Rp', '.', ' '], '', $request->harga),
            'deskripsi'         => $request->deskripsi,
        ]);

        return redirect()->route('paket.index')->with('success_paket', 'Paket berhasil ditambahkan!');
    }


    public function store_maskapai(Request $request)
    {
        $request->validate([
            'nama_maskapai' => 'required|string|max:255',
            'kode_maskapai' => 'nullable|string|max:20',
        ]);

        Maskapai::create([
            'nama_maskapai' => $request->nama_maskapai,
            'kode_maskapai' => $request->kode_maskapai,
        ]);

        return back()->with('success_maskapai', 'Maskapai berhasil ditambahkan!');
    }

    public function edit_paket($id)
    {
        $paket = Paket::findOrFail($id);
        $maskapai = Maskapai::all();
        return view('admin.utama.manajemen_paket.edit_data', compact('paket', 'maskapai'));
    }

    public function update_paket(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_paket'       => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'harga'            => 'required'
        ]);

        $lokasiMekkah = $request->lat_mekkah && $request->lng_mekkah
            ? $request->lat_mekkah . ',' . $request->lng_mekkah
            : null;

        $lokasiMadinah = $request->lat_madinah && $request->lng_madinah
            ? $request->lat_madinah . ',' . $request->lng_madinah
            : null;

        // Ambil paket berdasarkan ID
        $paket = Paket::findOrFail($id);

        // Update data
        $paket->update([
            'nama_paket'        => $request->nama_paket,
            'jenis_paket'       => $request->jenis_paket,
            'tgl_berangkat'     => $request->tanggal_berangkat,
            'kuota'             => $request->kuota,
            'hotel_mekkah'      => $request->hotel_mekkah,
            'hotel_madinah'     => $request->hotel_madinah,
            'lokasi_mekkah'     => $lokasiMekkah,   // 👈 hasil gabungan
            'lokasi_madinah'    => $lokasiMadinah,  // 👈 hasil gabungan
            'harga_paket'       => $request->harga,
            'deskripsi'         => $request->deskripsi,
        ]);

        // Redirect dengan flash session
        return redirect()->route('paket.index')->with('success_update', 'Paket berhasil diperbarui!');
    }

    public function destroy_paket($id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return back()->with('deleteSuccess', 'Paket berhasil dihapus!');
    }

    public function log_aktifitas()
    {
        $logs = Log_activity::with('user')->latest()->paginate(20);
        return view('admin.utama.log_aktifitas.tampil_data', compact('logs'));
    }

    public function tampil_pembayaran()
    {
        $pemasukan = Pemasukan::with('jamaah')->get();
        return view('admin.utama.pemasukan.pembayaran.tampil_data', compact('pemasukan'));
    }

    public function tampil_investasi()
    {
        return view('admin.utama.pemasukan.investasi.tampil_data');
    }

    public function tampil_pengeluaran()
    {
        $pengeluaran = Pengeluaran::all();
        return view('admin.utama.pengeluaran.tampil_data', compact('pengeluaran'));
    }

    public function store_pengeluaran(Request $request)
    {
        $pengeluaran = Pengeluaran::create([
            'item' => $request->item,
            'kuantiti' => $request->kuantiti,
            'satuan' => $request->satuan,
            'harga_satuan' => $request->harga_satuan,
            'created_by' => Auth::user()->username,
            'total_harga' => $request->total_harga
        ]);

        // generate PDF
        $pdf = Pdf::loadView('admin.utama.pengeluaran.pengajuan_pdf', compact('pengeluaran'));

        $filename = 'pengeluaran_' . $pengeluaran->id . '.pdf';

        Storage::put('public/pengeluaran/' . $filename, $pdf->output());

        // simpan path pdf
        $pengeluaran->update([
            'bukti' => 'pengeluaran/' . $filename
        ]);

        logActivity(
            'create',
            'Pengeluaran',
            $pengeluaran->id,
            'Pengajuan Pengeluaran berhasil Dibuat!'
        );

        return redirect()->back()->with('success_pengeluaran', 'Data berhasil ditambahkan');
    }

    public function update_pengeluaran(Request $request, $id)
    {
        $data = Pengeluaran::findOrFail($id);

        // update data
        $data->update([
            'item' => $request->item,
            'kuantiti' => $request->kuantiti,
            'satuan' => $request->satuan,
            'harga_satuan' => $request->harga_satuan,
            'total_harga' => $request->total_harga,
        ]);

        // reload data terbaru
        $pengeluaran = Pengeluaran::find($id);

        // generate ulang PDF
        $pdf = Pdf::loadView('admin.utama.pengeluaran.pengajuan_pdf', compact('pengeluaran'));

        $filename = 'pengeluaran_' . $pengeluaran->id . '.pdf';
        $path = 'public/pengeluaran/' . $filename;

        // jika file lama ada hapus dulu (opsional)
        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        // simpan file baru
        Storage::put($path, $pdf->output());

        // update path jika belum ada
        if (!$pengeluaran->bukti) {
            $pengeluaran->update([
                'bukti' => 'pengeluaran/' . $filename
            ]);
        }

        logActivity(
            'update',
            'Pengeluaran',
            $pengeluaran->id,
            'Data pengeluaran berhasil Diupdate!'
        );

        return back()->with('success_update_pengeluaran', 'Data berhasil diupdate dan PDF diperbarui');
    }

    public function destroy_pengeluaran($id)
    {
        $data = Pengeluaran::findOrFail($id);

        // jika sudah divalidasi tidak boleh dihapus
        if ($data->validation_by != null) {
            return back()->with('error_hapus_data', 'Data yang sudah divalidasi tidak bisa dihapus');
        }

        // hapus file PDF jika ada
        if ($data->bukti) {

            $filePath = 'public/' . $data->bukti;

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }

        // hapus data dari database
        $data->delete();

        logActivity(
            'delete',
            'Pengeluaran',
            $data->id,
            'Data pengeluaran berhasil Dihapus!'
        );

        return back()->with('success_delete_pengeluaran', 'Data pengeluaran berhasil dihapus');
    }

    public function verifikasi_pengeluaran($id)
    {
        $data = Pengeluaran::findOrFail($id);

        // 🔥 CEK apakah jamaah punya tiket
        $punyaTiket = TiketBerangkat::where('id_jamaah', $data->jamaah_id)->exists();

        if (!$punyaTiket) {
            return back()->with('error_tiket', 'Jamaah belum memiliki tiket!');
        }


        $data->update([
            'verified_by' => Auth::user()->username,
            'verified_at' => now()
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


    public function lihatPdf($id)
    {
        $data = Pengeluaran::findOrFail($id);

        $path = storage_path('app/public/' . $data->bukti);

        return response()->file($path);
    }

    public function manajemen_logistik()
    {
        $logistik = Logistik::all();
        return view('admin.utama.manajemen_logistik.tampil_data', compact('logistik'));
    }

    public function tambah_data_logistik()
    {
        $paket = Paket::all();
        return view('admin.utama.manajemen_logistik.tambah_data', compact('paket'));
    }

    public function store_logistik(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'bukti_penyerahan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();

        try {

            // Upload file
            $filePath = null;
            if ($request->hasFile('bukti_penyerahan')) {
                $filePath = $request->file('bukti_penyerahan')
                    ->store('bukti_pengadaan', 'public');
            }

            // Simpan logistik
            $logistik = Logistik::create([
                'nama_barang' => $request->nama_barang,
                'jumlah' => $request->jumlah,
                'bukti_penyerahan' => $filePath,
            ]);

            // Simpan pengeluaran
            $pengeluaran = Pengeluaran::create([
                'item' => $request->nama_barang,
                'kuantiti' => $request->jumlah,
                'satuan' => 'PCS',
                'created_by' => Auth::user()->username
            ]);

            // Log activity untuk logistik
            logActivity(
                'create',
                'Logistik',
                $logistik->id,
                'Menambahkan data logistik: ' . $logistik->nama_barang
            );

            // Log activity untuk pengeluaran
            logActivity(
                'create',
                'Pengeluaran',
                $pengeluaran->id,
                'Menambahkan pengeluaran dari logistik: ' . $pengeluaran->item
            );

            DB::commit();

            return redirect()->route('logistik.index')
                ->with('success_logistik', 'Data logistik berhasil disimpan');
        } catch (\Exception $e) {

            DB::rollback();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit_logistik($id)
    {
        $logistik = Logistik::findOrFail($id);
        return view('admin.utama.manajemen_logistik.edit_data', compact('logistik'));
    }

    public function update_logistik(Request $request, $id)
    {
        $logistik = Logistik::findOrFail($id);

        // ✅ Validasi
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'bukti_penyerahan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // ✅ Jika upload file baru
        if ($request->hasFile('bukti_penyerahan')) {

            // hapus file lama
            if ($logistik->bukti_penyerahan && Storage::disk('public')->exists($logistik->bukti_penyerahan)) {
                Storage::disk('public')->delete($logistik->bukti_penyerahan);
            }

            // simpan file baru
            $logistik->bukti_penyerahan = $request->file('bukti_penyerahan')
                ->store('bukti_pengadaan', 'public');
        }

        // ✅ Update data
        $logistik->update([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'bukti_penyerahan' => $logistik->bukti_penyerahan,
        ]);

        logActivity(
            'update',
            'Logistik',
            $logistik->id,
            'Update data logistik: ' . $logistik->nama_barang
        );

        return redirect()->route('logistik.index')
            ->with('success_update_logistik', 'Data logistik berhasil diperbarui');
    }

    public function destroy_logistik($id)
    {
        $logistik = Logistik::findOrFail($id);

        // ✅ hapus file
        if ($logistik->bukti_penyerahan && Storage::disk('public')->exists($logistik->bukti_penyerahan)) {
            Storage::disk('public')->delete($logistik->bukti_penyerahan);
        }

        // ✅ hapus data
        $logistik->delete();

        logActivity(
            'delete',
            'Logistik',
            $logistik->id,
            'Hapus data logistik: ' . $logistik->nama_barang
        );

        return redirect()->back()
            ->with('success_hapus_logistik', 'Data logistik berhasil dihapus');
    }

    public function tampil_distribusi()
    {
        $jamaah = Jamaah::with([
            'pakets',
            'penyerahan.distribusiLogistik.logistik'
        ])->get();
        return view('admin.utama.distribusi.tampil_data', compact('jamaah'));
    }

    public function validasiLogistik(Request $request)
    {
        DB::transaction(function () use ($request) {

            $jamaah = Jamaah::findOrFail($request->jamaah_id);

            // ambil penyerahan jamaah
            $penyerahan = Penyerahan::where('jamaah_id', $jamaah->id)->first();

            // ambil barang yang diserahkan
            $distribusi = DistribusiLogistik::where('penyerahan_id', $penyerahan->id)->get();

            foreach ($distribusi as $item) {

                $logistik = Logistik::find($item->logistik_id);

                if ($logistik->jumlah > 0) {
                    $logistik->decrement('jumlah', 1);
                }
            }

            // update status jamaah
            $jamaah->update([
                'status_logistik' => 1
            ]);

            logActivity(
                'update',
                'Jamaah',
                $jamaah->id,
                'Validasi penerimaan logistik oleh jamaah: ' . $jamaah->nama_depan . ' ' . $jamaah->nama_belakang
            );
        });

        return response()->json([
            'success' => true,
            'message' => 'Logistik berhasil divalidasi'
        ]);
    }

    public function tampil_tiket()
    {
        $berangkat = TiketBerangkat::with('jamaah')->where('jenis', 1)->latest()->limit(5)->get();
        $pulang = TiketBerangkat::with('jamaah')->where('jenis', 2)->latest()->limit(5)->get();
        $jamaah = Jamaah::where('status_validasi', 1)->get();
        return view('admin.utama.tiket.tampil_data', compact('berangkat', 'pulang', 'jamaah'));
    }

    public function store_tiket(Request $request)
    {
        $jamaah = Jamaah::find($request->jamaah_id);

        $tiket = TiketBerangkat::create([
            'id_jamaah' => $request->jamaah_id,
            'tgl_berangkat' => $request->tanggal,
            'waktu_berangkat' => $request->waktu_berangkat,
            'waktu_sampai' => $request->waktu_sampai,
            'maskapai' => $request->maskapai,
            'kode' => $request->pnr,
            'bandara' => $request->bandara,
            'jenis' => $request->jenis,
            'created_by'  => Auth::user()->username,
        ]);

        $jenisText = $request->jenis == 1 ? 'Berangkat' : 'Pulang';

        logActivity(
            'create',
            'Tiket',
            $tiket->id,
            'Tiket ' . $jenisText . ' untuk jamaah dengan nama : '
                . $jamaah->nama_depan . ' ' . $jamaah->nama_belakang . ' berhasil di simpan'
        );

        return back()->with('success_tiket', 'Data tiket berhasil ditambahkan');
    }

    public function update_tiket(Request $request, $id)
    {
        $tiket = TiketBerangkat::findOrFail($id);

        $jamaah = Jamaah::find($request->jamaah_id);

        $tiket->update([
            'jamaah_id' => $request->jamaah_id,
            'tgl_berangkat' => $request->tgl_berangkat,
            'waktu_berangkat' => $request->waktu_berangkat,
            'waktu_sampai' => $request->waktu_sampai,
            'maskapai' => $request->maskapai,
            'kode' => $request->kode,
            'bandara' => $request->bandara,
        ]);

        $jenisText = $request->jenis == 1 ? 'Berangkat' : 'Pulang';

        logActivity(
            'update',
            'Tiket',
            $tiket->id,
            'Tiket ' . $jenisText . ' untuk jamaah dengan nama : '
                . $jamaah->nama_depan . ' ' . $jamaah->nama_belakang . ' berhasil di update'
        );

        return back()->with('success_update_tiket', 'Data berhasil diupdate');
    }


    public function manajemen_komentar()
    {
        $komentar = Komentar::all();
        return view('admin.utama.komentar.tampil_data', compact('komentar'));
    }

    public function validasi_komentar(Request $request, $id)
    {
        $komentar = Komentar::findOrFail($id);

        $komentar->status = 1;
        $komentar->save();

        logActivity(
            'udpate',
            'Komentar',
            $komentar->id,
            'Berhasil validasi komentar dengan nama: ' . $komentar->nama
        );

        return redirect()->back()->with('success_validasi_komentar', 'Status validasi berhasil diupdate!');
    }

    public function destroy_komentar($id)
    {
        $komentar = Komentar::findOrFail($id);
        $komentar->delete();

        logActivity(
            'delete',
            'Komentar',
            $komentar->id,
            'Berhasil hapus komentar dengan nama: ' . $komentar->nama
        );

        return back()->with('deleteKomentar', 'Komentar berhasil dihapus!');
    }

    public function tampil_laporan()
    {
        $jamaah = Jamaah::where('status_validasi', 1)->get();
        $pekerjaan = Pekerjaan::all();
        return view('admin.utama.laporan.tampil_laporan', compact('jamaah', 'pekerjaan'));
    }

    public function edit_laporan($id)
    {
        $siskopatu = Siskopatu::with('jamaah')->findOrFail($id);

        return response()->json([
            'siskopatu' => $siskopatu,
            'jamaah' => $siskopatu->jamaah
        ]);
    }

    public function store_laporan(Request $request)
    {
        // validasi (sama seperti update)
        $request->validate([
            'title' => 'nullable|string',
            'nama_lengkap' => 'required|string',
            'nama_ayah' => 'nullable|string',
            // 'jenis_identitas' => 'required',
            'no_identitas' => 'nullable|string',
            'tgl_lahir' => 'nullable|date',
            'no_hp' => 'nullable|string',
        ]);

        // simpan data baru
        Siskopatu::create([
            'title' => $request->title,
            'nama_lengkap' => $request->nama_lengkap,
            'nama_ayah' => $request->nama_ayah,
            'jenis_identitas' => $request->jenis_identitas,
            'no_identitas' => $request->no_identitas,
            'nama_paspor' => $request->nama_paspor,
            'no_paspor' => $request->no_paspor,
            'tgl_paspor' => $request->tgl_paspor,
            'kota_paspor' => $request->kota_paspor,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tgl_lahir,
            'alamat_lengkap' => $request->alamat_lengkap,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'no_telepon' => $request->no_telepon,
            'no_hp' => $request->no_hp,
            'kewarganegaraan' => $request->kewarganegaraan,
            'status_pernikahan' => $request->status_pernikahan,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'pekerjaan_lainnya' => $request->pekerjaan_lainnya,
            'provider_visa' => $request->provider_visa,
            'no_visa' => $request->no_visa,
            'tgl_awal_visa' => $request->tgl_awal_visa,
            'tgl_akhir_visa' => $request->tgl_akhir_visa,
            'asuransi' => $request->asuransi,
            'no_polis' => $request->no_polis,
            'tgl_input_polis' => $request->tgl_input_polis,
            'tgl_awal_polis' => $request->tgl_awal_polis,
            'tgl_akhir_polis' => $request->tgl_akhir_polis,
            'no_bpjs' => $request->no_bpjs,
        ]);

        return redirect()->back()
            ->with('success_store_laporan', 'Data berhasil ditambahkan');
    }

    public function update_laporan(Request $request, $id)
    {
        $siskopatu = Siskopatu::findOrFail($id);

        // update sesuai field
        $siskopatu->update($request->all());

        return response()->json([
            'message' => 'Data berhasil diperbarui'
        ]);
    }


    public function getNoKtp($id)
    {
        $jamaah = Jamaah::find($id);

        if ($jamaah && $jamaah->no_ktp) {
            return response()->json(['no_ktp' => $jamaah->no_ktp]);
        } else {
            return response()->json(['no_ktp' => '']);
        }
    }

    public function tampil_notifikasi($id)
    {
        $jamaah = Jamaah::join('pakets', 'pakets.id', '=', 'jamaahs.paket_id')
            ->select(
                'jamaahs.id',
                'jamaahs.kontak_darurat_hp',
                'jamaahs.tgl_keberangkatan',
                DB::raw("TRIM(CONCAT(jamaahs.nama_depan, ' ', COALESCE(jamaahs.nama_belakang, ''))) AS nama_lengkap"),
                'pakets.nama_paket',
                'pakets.tgl_berangkat'
            )
            ->where('jamaahs.id', $id)
            ->firstOrFail();
        // $paket  = Paket::select('nama_paket', 'tgl_berangkat')->get();
        return view('admin.utama.manajemen_jamaah.tampil_notifikasi', compact('jamaah'));
    }


    public function kirim_notifikasi(Request $request)
    {
        $token = env('FONNTE_TOKEN');

        $target = $request->no_telepon;   // nomor tujuan
        // $target = "083809808665";
        $pesan  = $request->pesan;    // isi pesan

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $pesan,
                'delay' => '2',
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error_msg = curl_error($curl);
        curl_close($curl);

        if ($error_msg || $httpCode != 200) {
            return redirect()->route('jamaah.index')->with('error_kirim_pesan', 'Gagal kirim pesan!');
        }

        return redirect()->route('jamaah.index')->with('success_kirim_pesan', 'Pesan berhasil dikirim!');
    }

    public function kirim_notifikasi_grup(Request $request)
    {
        $token = env('FONNTE_TOKEN');

        $target = $request->no_telepon;   // nomor tujuan
        // $target = "083809808665";
        $pesan  = $request->pesan;    // isi pesan

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $pesan,
                'delay' => '2',
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error_msg = curl_error($curl);
        curl_close($curl);

        if ($error_msg || $httpCode != 200) {
            return redirect()->route('keberangkatan.index')->with('error_kirim_pesan', 'Gagal kirim pesan!');
        }

        return redirect()->route('keberangkatan.index')->with('success_kirim_pesan', 'Pesan berhasil dikirim!');
    }

    public function tampil_keberangkatan()
    {
        $jamaah = Jamaah::where('status_validasi', 1)->get();
        $rombongan = Rombongan::with(['pembimbing', 'paket'])->get();
        return view('admin.utama.manajamen_keberangkatan.daftar_jamaah.tampil_data', compact('jamaah', 'rombongan'));
    }

    public function tambahRombongan(Request $request)
    {
        $jamaah = Jamaah::findOrFail($request->jamaah_id);

        $jamaah->update([
            'id_rombongan' => $request->rombongan_id
        ]);

        logActivity(
            'create',
            'Rombongan',
            $jamaah->id,
            'Berhasil menambahkan rombongan untuk jamaah dengan id: ' . $jamaah->id
        );

        return back()->with('success_rombongan', 'Jamaah berhasil dimasukkan ke rombongan.');
    }

    public function updateRombongan(Request $request)
    {
        $jamaah = Jamaah::findOrFail($request->jamaah_id);
        $jamaah->id_rombongan = $request->rombongan_id;
        $jamaah->save();

        logActivity(
            'update',
            'Rombongan',
            $jamaah->id,
            'Rombongan untuk ' . $jamaah->nama_depan . ' ' . $jamaah->nama_belakang . ' berhasil Diubah!'
        );

        return redirect()->back()->with('success_update_rombongan', 'Rombongan berhasil diubah!');
    }

    public function generateKodeRombongan()
    {
        $last = Rombongan::orderBy('id', 'desc')->first();

        $lastNumber = 0;

        if ($last && preg_match('/(\d+)$/', $last->kode_rombongan, $matches)) {
            $lastNumber = (int) $matches[1];
        }

        $newNumber = $lastNumber + 1;

        return 'ROMB-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function generateKode()
    {
        return response()->json([
            'kode' => $this->generateKodeRombongan()
        ]);
    }

    public function tampil_pembimbing()
    {
        $pembimbing = Pembimbing::all();
        return view('admin.utama.manajamen_keberangkatan.pembimbing.tampil_data', compact('pembimbing'));
    }

    public function store_pembimbing(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'no_hp' => 'required|string',
            'email' => 'nullable|email',
            'alamat' => 'nullable|string',
        ]);

        $pembimbing = Pembimbing::create($request->all());

        logActivity(
            'create',
            'Pembimbing',
            $pembimbing->id,
            'Pembimbing dengan nama ' . $pembimbing->nama_lengkap . ' berhasil Ditambahkan!'
        );

        return redirect()->route('pembimbing.index')->with('success_pembimbing', 'Data pembimbing berhasil ditambahkan!');
    }


    public function tampil_rombongan()
    {
        $rombongan = Rombongan::with(['pembimbing', 'pembimbing2', 'pembimbing3', 'pembimbing4', 'pembimbing5', 'paket'])->get();
        $pembimbing = Pembimbing::all();
        $paket = Paket::where('jenis_paket', '!=', 'private')->get();
        $jamaah = Jamaah::count();
        return view('admin.utama.manajamen_keberangkatan.rombongan.tampil_data', compact('rombongan', 'pembimbing', 'paket', 'jamaah'));
    }

    public function store_rombongan(Request $request)
    {

        $request->merge([
            'kode_rombongan' => $this->generateKodeRombongan()
        ]);

        $request->validate([
            'kode_rombongan' => 'required|string',
            'nama_rombongan' => 'required|string',
            'jumlah_jamaah' => 'required|integer|min:1',
            'id_pembimbing' => 'required',
            'id_pembimbing2' => 'nullable|different:pembimbing_1',
            'id_pembimbing3' => 'nullable|different:pembimbing_1|different:pembimbing_2',
            'id_pembimbing4' => 'nullable|different:pembimbing_1|different:pembimbing_2|different:pembimbing_3',
            'id_pembimbing5' => 'nullable|different:pembimbing_1|different:pembimbing_2|different:pembimbing_3|different:pembimbing_4',
        ]);

        $rombongan = Rombongan::create([
            'kode_rombongan'          => $request->kode_rombongan,
            'nama_rombongan'  => $request->nama_rombongan,
            'id_paket'      => $request->id_paket,
            'id_pembimbing'         => $request->id_pembimbing,
            'id_pembimbing2'  => $request->id_pembimbing2,
            'id_pembimbing3'  => $request->id_pembimbing3,
            'id_pembimbing4'  => $request->id_pembimbing4,
            'id_pembimbing5'  => $request->id_pembimbing5,
            'tgl_keberangkatan'         => $request->tgl_keberangkatan,
            'tanggal_kembali'         => $request->tanggal_kembali,
            'jumlah_jamaah'       => $request->jumlah_jamaah,
        ]);

        $pengeluaran = Pengeluaran::create([
            'item' => 'Pembayaran Asuransi Rombongan ' . $request->nama_rombongan,
            'kuantiti' => $request->jumlah_jamaah,
            'satuan' => 'Grup',
            'created_by' => Auth::user()->username
        ]);

        logActivity(
            'create',
            'Rombongan',
            $rombongan->id,
            'Rombongan ' . $rombongan->nama_rombongan . ' berhasil ditambahkan!'
        );

        logActivity(
            'create',
            'Pengeluaran',
            $pengeluaran->id,
            'Menambahkan pengeluaran untuk : ' . $pengeluaran->item
        );

        // Rombongan::create($request->all());

        return redirect()->route('rombongan.index')->with('success_rombongan', 'Rombongan berhasil ditambahkan!');
    }

    public function getInfoPaket($id)
    {
        $paket = Paket::findOrFail($id);

        $jumlahJamaah = Jamaah::where('paket_id', $id)->count();

        return response()->json([
            'tgl_berangkat' => $paket->tgl_berangkat,
            'jumlah_jamaah' => $jumlahJamaah,
        ]);
    }

    public function update_pembimbing(Request $request)
    {
        $pembimbing = Pembimbing::where('id', $request->pembimbing_id)->update([
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp'        => $request->no_hp,
            'email'        => $request->email,
            'alamat'       => $request->alamat,
        ]);

        logActivity(
            'update',
            'Pembimbing',
            $pembimbing->id,
            'Pembimbing dengan nama ' . $pembimbing->nama_lengkap . ' berhasil Diupdate!'
        );

        return back()->with('success_update_pembimbing', 'Data pembimbing berhasil diperbarui!');
    }

    public function destroy_pembimbing($id)
    {
        // Cek apakah pembimbing digunakan di tabel rombongan untuk mencegah error
        $dipakai = Rombongan::where('id_pembimbing', $id)->exists();

        if ($dipakai) {
            return back()->with('error_pembimbing', 'Tidak dapat menghapus pembimbing karena masih terhubung dengan rombongan.');
        }

        $pembimbing = Pembimbing::findOrFail($id);
        $pembimbing->delete();

        logActivity(
            'delete',
            'Pembimbing',
            $pembimbing->id,
            'Pembimbing dengan nama ' . $pembimbing->nama_lengkap . ' berhasil Dihapus!'
        );

        return back()->with('success_hapus_pembimbing', 'Pembimbing berhasil dihapus.');
    }

    public function notif_pembimbing()
    {
        $pembimbing = Pembimbing::all();
        return view('admin.utama.manajamene_keberangkatan.pembimbing.notif', compact('pembimbing'));
    }

    public function update_rombongan(Request $request, $id)
    {
        $rombongan = Rombongan::findOrFail($id);

        $request->validate([
            'kode_rombongan' => 'required|unique:rombongans,kode_rombongan,' . $id,
            'nama_rombongan' => 'required',
            'id_paket' => 'required',
            'id_pembimbing' => 'required',
            'id_pembimbing2' => 'nullable',
            'id_pembimbing3' => 'nullable',
            'id_pembimbing4' => 'nullable',
            'id_pembimbing5' => 'nullable',
            'tgl_keberangkatan' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tgl_keberangkatan',
            'jumlah_jamaah' => 'required|integer|min:1',
        ]);

        $rombongan->update($request->all());

        logActivity(
            'update',
            'Rombongan',
            $rombongan->id,
            'Rombongan ' . $rombongan->nama_rombongan . ' berhasil Diupdate!'
        );

        return redirect()->back()->with('success_update_rombongan', 'Rombongan berhasil diupdate.');
    }

    public function destroy_rombongan($id)
    {
        $rombongan = Rombongan::findOrFail($id);
        $rombongan->delete();

        logActivity(
            'delete',
            'Rombongan',
            $rombongan->id,
            'Rombongan ' . $rombongan->nama_rombongan . ' berhasil Dihapus!'
        );

        return redirect()->back()->with('success_hapus_rombongan', 'Rombongan berhasil dihapus.');
    }



    public function tampil_visa()
    {
        $visa = Jamaah::all();
        return view('admin.utama.visa.tampil_data', compact('visa'));
    }

    public function update_visa(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status_visa' => 'required',
            'foto_visa' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $visa = Jamaah::findOrFail($request->id);

        // Update status
        $visa->status_visa = $request->status_visa;

        // Jika upload file baru
        if ($request->hasFile('foto_visa')) {

            // hapus file lama jika ada
            if ($visa->foto_visa && Storage::disk('public')->exists($visa->foto_visa)) {
                Storage::disk('public')->delete($visa->foto_visa);
            }

            $file = $request->file('foto_visa');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('visa', $namaFile, 'public');

            $visa->foto_visa = $path;
        }

        $visa->save();

        logActivity(
            'update',
            'visa',
            $visa->id,
            'Visa untuk jamaah dengan nama ' .  $visa->nama_depan . ' ' . $visa->nama_belakang  . ' berhasil Ditambahkan!'
        );

        return redirect()->back()->with('success_update', 'Data visa berhasil diperbarui');
    }

    public function tampil_komisi()
    {
        $komisi = Komisi::with('jamaah', 'marketing')->get();
        return view('admin.utama.komisi.tampil_data', compact('komisi'));
    }

    public function update_komisi(Request $request)
    {
        $komisi = Komisi::findOrFail($request->id);

        $komisi->update([
            'nominal_komisi' => $request->nominal_komisi,
            'tgl_cair' => $request->tgl_cair,
        ]);

        return back()->with('success_komisi', 'Data komisi berhasil diupdate');
    }

    public function validasi_komisi($id)
    {
        $komisi = Komisi::findOrFail($id);

        // Update status_validasi menjadi 1
        $komisi->status = 1;
        $komisi->save();

        logActivity(
            'delete',
            'Jamaah',
            $komisi->id,
            'Komisi untuk  ' . $komisi->marketing->username . ' berhasil divalidasi!'
        );

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success_komisi_validasi', 'Jamaah berhasil dihapus!');
    }

    public function tampil_asuransi()
    {
        $asuransi = Rombongan::all();
        return view('admin.utama.asuransi.tampil_data', compact('asuransi'));
    }

    public function update_asuransi(Request $request)
    {
        $data = Rombongan::findOrFail($request->id);

        $data->status_asuransi = $request->status_asuransi;

        if ($request->hasFile('file_asuransi')) {

            $file = $request->file('file_asuransi');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('asuransi', $namaFile, 'public');

            $data->foto_asuransi = $path;
        }

        $data->save();

        logActivity(
            'update',
            'rombongan',
            $data->id,
            'Asuransi untuk rombongan ' .  $data->nama_rombongan  . ' berhasil Ditambahkan!'
        );

        return back()->with('success_update_asuransi', 'Data asuransi berhasil diperbarui');
    }
}
