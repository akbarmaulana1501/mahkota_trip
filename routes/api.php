<?php

use App\Http\Controllers\JamaahController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Jamaah;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/api/jamaah', function(Request $request){
    $tglAwal = $request->query('tgl_awal');
    $tglAkhir = $request->query('tgl_akhir');

    $columns = ['Title', 'Nama', 'Nama Ayah','Jenis Identitas','No Identitas','Nama Paspor','No Paspor','Tanggal Dikeluarkan Paspor','Kota Paspor','Tempat Lahir','Alamat','Provinsi','Kabupaten','Kecamatan','No. Telepon','No Hp','KewargaNegaraan','Status Pernikahan','Pendidikan','Pekerjaan','Provider Visa','No Visa','Tanggal Berlaku Visa','Tanggal Akhir Visa','Asuransi','No Polis','Tanggal Input Polis','Tanggal Awal Polis','Tanggal Akhir Polis', 'No BPJS'];

    $data = Jamaah::select($columns)
        ->whereBetween('tgl_input_polis', [$tglAwal, $tglAkhir])
        ->get();

    return response()->json($data);
});

Route::post('/midtrans/callback', [JamaahController::class, 'callback']);

