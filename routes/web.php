<?php

use App\Http\Controllers\AdminUtamaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\JamaahController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LogistikController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\PenjadwalanController;
use App\Http\Controllers\SAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//tampilan depan
Route::get('/', [IndexController::class, 'index']);


//login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'Auth']);


Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::get('/admin', [AdminUtamaController::class, 'index'])->name('indexAdminUtama')->middleware(['auth', 'role:admin,superadmin']);
Route::put('/admin/update-password', [AdminUtamaController::class, 'updatePassword'])->name('admin.updatePassword')->middleware(['auth', 'role:admin,superadmin']);


//User-Mendaftar
Route::post('/daftar-jamaah', [IndexController::class, 'store'])->name('jamaah.store');
Route::post('/ocr/scan', [IndexController::class, 'scanDocument'])->name('ocr.scanDocument');

//user-comment
Route::post('/pesan-kesan', [IndexController::class, 'pesan_kesan'])->name('pesan.store');

//manajemen_user
Route::get('/manajemen_user', [AdminUtamaController::class, 'manajemen_user'])->name('user.index')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/tambah_user', [AdminUtamaController::class, 'tambah_user'])->name('user.create')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/simpan_user', [AdminUtamaController::class, 'store_user'])->name('user.store')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/admin/user/{id}/edit', [AdminUtamaController::class, 'edit_user'])->name('user.edit')->middleware(['auth', 'role:admin,superadmin']);
Route::delete('/admin/user/{id}', [AdminUtamaController::class, 'destroy_user'])->name('user.delete')->middleware(['auth', 'role:admin,superadmin']);
Route::put('/user/update/{id}', [AdminUtamaController::class, 'update_user'])->name('user.update')->middleware(['auth', 'role:admin,superadmin']);


//manajemen_jamaah
Route::get('/manajemen_jamaah', [AdminUtamaController::class, 'tampil_jamaah'])->name('jamaah.index')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/tambah_jamaah', [AdminUtamaController::class, 'tambah_jamaah'])->name('jamaah.create')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/simpan_jamaah', [AdminUtamaController::class, 'store_jamaah'])->name('jamaah.store')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/admin/jamaah/{id}/edit', [AdminUtamaController::class, 'edit_jamaah'])->name('jamaah.edit')->middleware(['auth', 'role:admin,superadmin']);
Route::put('/admin/jamaah/{id}', [AdminUtamaController::class, 'update_jamaah'])->name('jamaah.update')->middleware(['auth', 'role:admin,superadmin']);
Route::delete('/admin/jamaah/{id}', [AdminUtamaController::class, 'destroy_jamaah'])->name('jamaah.delete')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/validasi-jamaah/{id}', [AdminUtamaController::class, 'validasi_jamaah'])->name('ValidasiJamaah')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/pembayaran/store', [AdminUtamaController::class, 'store_pembayaran_jamaah'])->name('pembayaran.store');

//notifikasi Wa
Route::get('/tampil_notifikasi/{id}', [AdminUtamaController::class, 'tampil_notifikasi'])->name('jamaah.notif')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/kirim_notifikasi', [AdminUtamaController::class, 'kirim_notifikasi'])->name('Notifikasi')->middleware(['auth', 'role:admin,superadmin']);

//keberangkatan
Route::get('/manajemen_keberangkatan', [AdminUtamaController::class, 'tampil_keberangkatan'])->name('keberangkatan.index')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/manajemen_pembimbing', [AdminUtamaController::class, 'tampil_pembimbing'])->name('pembimbing.index')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/manajemen_rombongan', [AdminUtamaController::class, 'tampil_rombongan'])->name('rombongan.index')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/Simpan_pembimbing', [AdminUtamaController::class, 'store_pembimbing'])->name('pembimbing.store')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/Simpan_rombongan', [AdminUtamaController::class, 'store_rombongan'])->name('rombongan.store')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/jamaah/tambah-rombongan', [AdminUtamaController::class, 'tambahRombongan'])->name('rombongan.create')->middleware(['auth', 'role:admin,superadmin']);
Route::put('/rombongan/edit', [AdminUtamaController::class, 'updateRombongan'])->name('rombongan.edit')->middleware(['auth', 'role:admin,superadmin']);
Route::put('/pembimbing/update', [AdminUtamaController::class, 'update_pembimbing'])->name('pembimbing.update')->middleware(['auth', 'role:admin,superadmin']);
Route::put('/rombongan/update/{id}', [AdminUtamaController::class, 'update_rombongan'])->name('rombongan.update')->middleware(['auth', 'role:admin,superadmin']);
Route::delete('/pembimbing/{id}', [AdminUtamaController::class, 'destroy_pembimbing'])->name('pembimbing.delete')->middleware(['auth', 'role:admin,superadmin']);
Route::delete('/rombongan/{id}', [AdminUtamaController::class, 'destroy_rombongan'])->name('rombongan.delete')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/kirim_notifikasi_grup', [AdminUtamaController::class, 'kirim_notifikasi_grup'])->name('Notifikasi_grup')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/pembimbing-notif/{id}', [AdminUtamaController::class, 'notif_pembimbing'])->name('pembimbing.notif')->middleware(['auth', 'role:admin,superadmin']);

Route::get('/generate-kode-rombongan', [AdminUtamaController::class, 'generateKode'])->middleware(['auth', 'role:admin,superadmin']);



// Route::get('/tambah_jamaah', [AdminUtamaController::class, 'tambah_jamaah'])->name('TambahJamaah');
// Route::post('/simpan_jamaah', [AdminUtamaController::class, 'store_jamaah'])->name('SimpanJamaah');
// Route::get('/admin/jamaah/{id}/edit', [AdminUtamaController::class, 'edit_jamaah'])->name('jamaah.edit');
Route::put('/admin/jamaah/{id}', [AdminUtamaController::class, 'update_jamaah'])->name('jamaah.update')->middleware(['auth', 'role:admin,superadmin']);
Route::delete('/admin/jamaah-unvalidate/{id}', [AdminUtamaController::class, 'unvalidate_jamaah'])->name('keberangkatan.unvalidate')->middleware(['auth', 'role:admin,superadmin']);


//manajemen paket
Route::get('/manajemen_paket', [AdminUtamaController::class, 'manajemen_paket'])->name('paket.index')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/tambah_paket', [AdminUtamaController::class, 'tambah_paket'])->name('paket.create')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/simpan_paket', [AdminUtamaController::class, 'store_paket'])->name('paket.store')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/admin/paket/{id}/edit', [AdminUtamaController::class, 'edit_paket'])->name('paket.edit')->middleware(['auth', 'role:admin,superadmin']);
Route::delete('/admin/paket/{id}', [AdminUtamaController::class, 'destroy_paket'])->name('paket.delete')->middleware(['auth', 'role:admin,superadmin']);
Route::put('/paket/update/{id}', [AdminUtamaController::class, 'update_paket'])->name('paket.update')->middleware(['auth', 'role:admin,superadmin']);
// Route::post('/maskapai/store', [AdminUtamaController::class, 'store_maskapai'])->name('maskapai.store')->middleware(['auth', 'role:admin,superadmin']);


Route::get('/paket/{id}/info', [AdminUtamaController::class, 'getInfoPaket'])->middleware(['auth', 'role:admin,superadmin']);


//pembayaran
// Route::get('/manajemen_pembayaran', [AdminUtamaController::class, 'manajemen_pembayaran'])->name('ManajemenPembayaran')->middleware(['auth', 'role:admin']);

//pemasukan
Route::get('/pembayaran', [AdminUtamaController::class, 'tampil_pembayaran'])->name('pembayaran')->middleware(['auth', 'role:admin,superadmin']);

Route::get('/investasi', [AdminUtamaController::class, 'tampil_investasi'])->name('investasi')->middleware(['auth', 'role:admin,superadmin']);

Route::get('/log-aktifitas', [AdminUtamaController::class, 'log_aktifitas'])->name('log_aktifitas')->middleware(['auth', 'role:admin,superadmin']);

Route::get('/pengeluaran', [AdminUtamaController::class, 'tampil_pengeluaran'])->name('pengeluaran')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/pengeluaran/store', [AdminUtamaController::class, 'store_pengeluaran'])->name('pengeluaran.store')->middleware(['auth', 'role:admin,superadmin']);
Route::put('/pengeluaran/{id}', [AdminUtamaController::class, 'update_pengeluaran'])->name('pengeluaran.update')->middleware(['auth', 'role:admin,superadmin']);;
Route::delete('/pengeluaran/{id}', [AdminUtamaController::class, 'destroy_pengeluaran'])->name('pengeluaran.destroy')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/pengeluaran/verifikasi/{id}', [AdminUtamaController::class, 'verifikasi_pengeluaran'])->name('pengeluaran.verifikasi')->middleware(['auth','role:admin,superadmin']);
Route::post('/pengeluaran/validasi/{id}', [SAdminController::class, 'validasi_pengeluaran'])->name('pengeluaran.validasi')->middleware(['auth','role:superadmin']);
Route::get('/lihat-pdf/{id}', [AdminUtamaController::class, 'lihatPdf'])->name('pengeluaran.pdf')->middleware(['auth','role:admin,superadmin']);

//visa
Route::get('/data-visa', [AdminUtamaController::class, 'tampil_visa'])->name('VisaJamaah')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/update-visa', [AdminUtamaController::class,'update_visa'])->name('UpdateVisa')->middleware(['auth', 'role:admin,superadmin']);

Route::get('/data-komisi', [AdminUtamaController::class, 'tampil_komisi'])->name('komisi_admin.index')->middleware(['auth', 'role:superadmin']);
Route::put('/update-komisi', [AdminUtamaController::class,'update_komisi'])->name('komisi_admin.update')->middleware(['auth', 'role:superadmin']);
Route::get('/validasi-komisi/{id}', [AdminUtamaController::class, 'validasi_komisi'])->name('validasi_komisi')->middleware(['auth', 'role:superadmin']);

//asuransi
Route::get('/data-asuransi', [AdminUtamaController::class, 'tampil_asuransi'])->name('AsuransiJamaah')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/update-asuransi', [AdminUtamaController::class,'update_asuransi'])->name('UpdateAsuransi')->middleware(['auth', 'role:admin,superadmin']);



//manajemen_logistik
Route::get('/manajemen_logistik', [AdminUtamaController::class, 'manajemen_logistik'])->name('logistik.index')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/tambah_logistik', [AdminUtamaController::class, 'tambah_data_logistik'])->name('logistik.create')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/simpan_logistik', [AdminUtamaController::class, 'store_logistik'])->name('logistik.store')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/admin/logistik/{id}/edit', [AdminUtamaController::class, 'edit_logistik'])->name('logistik.edit')->middleware(['auth', 'role:admin,superadmin']);
Route::delete('/admin/logistik/{id}', [AdminUtamaController::class, 'destroy_logistik'])->name('logistik.delete')->middleware(['auth', 'role:admin,superadmin']);
Route::put('/logistik/update/{id}', [AdminUtamaController::class, 'update_logistik'])->name('logistik.update')->middleware(['auth', 'role:admin,superadmin']);

//distribusi
Route::get('/distribusi-logistik', [AdminUtamaController::class, 'tampil_distribusi'])->name('ShowDistribusi')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/distribusi/validasi', [AdminUtamaController::class, 'validasiLogistik'])->name('logistik.validasi')->middleware(['auth', 'role:admin,superadmin']);

Route::get('/tiket', [AdminUtamaController::class, 'tampil_tiket'])->name('tiket.index')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/tiket/store', [AdminUtamaController::class, 'store_tiket'])->name('tiket.store')->middleware(['auth', 'role:admin,superadmin']);
Route::put('/tiket/{id}', [AdminUtamaController::class, 'update_tiket'])->name('tiket.update')->middleware(['auth', 'role:admin,superadmin']);


//manajemen_komentar
Route::get('/manajemen_komentar', [AdminUtamaController::class, 'manajemen_komentar'])->name('ManajemenKomentar')->middleware(['auth', 'role:admin,superadmin']);
Route::delete('/admin/komentar/{id}', [AdminUtamaController::class, 'destroy_komentar'])->name('komentar.destroy')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/validasi-komentar/{id}', [AdminUtamaController::class, 'validasi_komentar'])->name('validasi-komentar')->middleware(['auth', 'role:admin,superadmin']);

//Laporan
Route::get('/laporan', [AdminUtamaController::class, 'tampil_laporan'])->name('TampilLaporan')->middleware(['auth', 'role:admin,superadmin']);
Route::get('/jamaah/{id}/no-ktp', [AdminUtamaController::class, 'getNoKtp'])->middleware(['auth', 'role:admin,superadmin']);
Route::get('/laporan/{id}/edit', [AdminUtamaController::class, 'edit_laporan'])->name('EditLaporan')->middleware(['auth', 'role:admin,superadmin']);
Route::put('/laporan/{id}', [AdminUtamaController::class, 'update_laporan'])->name('updateLaporan')->middleware(['auth', 'role:admin,superadmin']);
Route::post('/laporan', [AdminUtamaController::class, 'store_laporan'])->name('laporan.store')->middleware(['auth', 'role:admin,superadmin']);


//marketing-role
//dashboard-marketing
Route::get('/marketing', [MarketingController::class, 'index'])->name('dashMarketing')->middleware(['auth', 'role:marketing']);
// Route::get('/dash-superadmin', [SAdminController::class, 'index'])->name('dashSuperAdmin')->middleware(['auth', 'role:superadmin']);

//calon_jamaah
Route::get('/calon-jamaah', [MarketingController::class, 'calon_jamaah'])->name('calonjamaah.index')->middleware(['auth', 'role:marketing']);
Route::get('/tambah-jamaah', [MarketingController::class, 'daftar_calon_jamaah'])->name('tambahCalonJamaah')->middleware(['auth', 'role:marketing']);
Route::post('/simpan-jamaah', [MarketingController::class, 'store_calon_jamaah'])->name('simpanCalonJamaah')->middleware(['auth', 'role:marketing']);
Route::get('/calon-jamaah/{id}', [MarketingController::class, 'edit_data_calon_jamaah'])->name('calonjamaah.edit')->middleware(['auth', 'role:marketing']);
Route::put('/calon-jamaah/update/{id}', [MarketingController::class,'update_calon_jamaah'])->name('calonjamaah.update')->middleware(['auth', 'role:marketing']);
Route::post('/calon-jamaah/validasi/{id}', [MarketingController::class, 'validasi'])->name('calonjamaah.validasi');

//komisi
Route::get('/komisi', [MarketingController::class, 'komisi'])->name('komisi.index')->middleware(['auth', 'role:marketing']);







//jamaah-role
Route::get('/dashboard-jamaah', [JamaahController::class, 'index'])->name('dashJamaah')->middleware(['auth:jamaah']);
//tagihan
Route::get('/tagihan-jamaah', [JamaahController::class, 'tagihan'])->name('tagihanJamaah')->middleware(['auth:jamaah']);
//dokumen
Route::get('/dokumen-jamaah', [JamaahController::class, 'dokumen'])->name('dokumenJamaah')->middleware(['auth:jamaah']);
//jadwal umroh
Route::get('/jadwal-jamaah', [JamaahController::class, 'jadwal_umroh'])->name('jadwalJamaah')->middleware(['auth:jamaah']);

Route::get('/logout-jamaah', [AuthController::class, 'logout_jamaah'])->name('logout_jamaah')->middleware(['auth:jamaah']);


//midtrans

Route::get('/payment/finish', [JamaahController::class, 'finish']);

Route::post('/generate-va', [JamaahController::class, 'generateVA'])->name('generate.va');
Route::post('/cek-va', [JamaahController::class, 'cekVA'])->name('cekVA');


//login_jamaah
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);


//logistik-role
Route::get('/dashboard-logistik', [LogistikController::class, 'index'])->name('dashLogistik')->middleware(['auth', 'role:logistik']);
Route::get('/tampil-logistik', [LogistikController::class, 'tampil_data_distribusi'])->name('ShowDistribusiLogis')->middleware(['auth', 'role:logistik']);
Route::post('/serahkan-logistik', [LogistikController::class, 'serahkanLogistik'])->name('logistik.serahkan')->middleware(['auth', 'role:logistik']);


Route::prefix('developer')->middleware(['auth','role:developer'])->group(function () {
    Route::get('/dashboard', [DevController::class, 'index'])->name('dashboard.dev');
    Route::get('/log_activities', [DevController::class, 'log_aktivitas'])->name('aktifitas.index');
    Route::get('/log_error', [DevController::class, 'log_error'])->name('error.index');
});



