<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredController;
use App\Http\Controllers\LoketController;
use App\Http\Controllers\LoketControllerManual;
use App\Http\Controllers\FarmasiController;
use App\Http\Controllers\TesAntrianController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoDisplaySettingController;

//23-11-2024
use App\Http\Controllers\LoketDobleController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['apikey'])->group(function () {
    // GET PASIEN
    Route::get('cari', [RegisteredController::class, 'cari'])->name('pasien.cari');

    // GET POLI
    Route::get('getpoli', [RegisteredController::class, 'Poliklinik'])->name('poliklinik.get');

    // Antrian A
    Route::post('antrian/store', [RegisteredController::class, 'store']);
    Route::post('antrian/update/{tgl}/{norm}/{dokter}/{poli}', [RegisteredController::class, 'update']);

    // Antrian B
    Route::post('antrian/storeb', [RegisteredController::class, 'storeb']);
    Route::post('antrian/updateb/{tgl}/{norm}/{dokter}/{poli}', [RegisteredController::class, 'updateb']);

    // Antrian C
    Route::post('antrian/storec', [RegisteredController::class, 'storec']);
    Route::post('antrian/updatec/{tgl}/{norm}/{dokter}/{poli}', [RegisteredController::class, 'updatec']);

    // Antrian D
    Route::post('antrian/stored', [RegisteredController::class, 'stored']);
    Route::post('antrian/updated/{tgl}/{norm}/{dokter}/{poli}', [RegisteredController::class, 'updated']);

    // Antrian E
    Route::post('antrian/storee', [RegisteredController::class, 'storee']);
    Route::post('antrian/updatee/{tgl}/{norm}/{dokter}/{poli}', [RegisteredController::class, 'updatee']);

    // Antrian F
    Route::post('antrian/storef', [RegisteredController::class, 'storef']);
    Route::post('antrian/updatef/{tgl}/{norm}/{dokter}/{poli}', [RegisteredController::class, 'updatef']);

    //Farmasi ANTRIAN A
    Route::get('farmasi/nomor/nomor-a/get', [FarmasiController::class, 'getNomorA'])->name('farmasi.nomora.get');
    Route::get('farmasi/nomor/antrian-a/get', [FarmasiController::class, 'getAntrianA'])->name('farmasi.antriana.get');
    Route::post('farmasi/nomor/antrian-a/tambah', [FarmasiController::class, 'tambahA'])->name('farmasi.antriana.store');

    //FARMASI ANTRIAN B
    Route::get('farmasi/nomor/nomor-b/get', [FarmasiController::class, 'getNomorB'])->name('farmasi.nomorb.get');
    Route::get('farmasi/nomor/antrian-b/get', [FarmasiController::class, 'getAntrianB'])->name('farmasi.antrianb.get');
    Route::post('farmasi/nomor/antrian-b/tambah', [FarmasiController::class, 'tambahB'])->name('farmasi.antrianb.store');

    //ANTRIAN FARMAMSI A DAN B
    Route::post('farmasi/nomor/antrian/panggil/{id}', [FarmasiController::class, 'panggilA'])->name('farmasi.antriana.panggil');
    Route::post('farmasi/nomor/antrian/stop/{id}', [FarmasiController::class, 'stopA'])->name('farmasi.antriana.stop');
    Route::post('farmasi/nomor/antrian/lewati/{id}', [FarmasiController::class, 'lewati'])->name('farmasi.antriana.lewati');
    Route::post('farmasi/nomor/antrian/selesai/{id}', [FarmasiController::class, 'selesai'])->name('farmasi.antriana.selesai');
    Route::post('farmasi/nomor/antrian/proses/{id}', [FarmasiController::class, 'proses'])->name('farmasi.antriana.proses');
    Route::get('farmasi/nomor/antrian/proses/get', [FarmasiController::class, 'getProses'])->name('farmasi.antriana.proses.get');

    //TEXT DISPLAY LOKET
    Route::get('loket/text_marquee', [LoketDobleController::class, 'text_marquee'])->name('loket.text_marquee');

    //VIDEO DISPLAY SETTINGS API
    Route::get('video-display-settings/{display}', [VideoDisplaySettingController::class, 'getByDisplay'])->name('video_display_settings.by_display');
});

//ANTRIAN LOKET
Route::get('loket/get', [LoketController::class, 'get'])->name('loket.get');
Route::post('loket/panggil/{kd}', [LoketController::class, 'panggil'])->name('loket.panggil');
Route::post('loket/stop/{kd}', [LoketController::class, 'stop'])->name('loket.stop');
Route::post('loket/lewati/{kd}', [LoketController::class, 'lewati'])->name('loket.lewati');
Route::post('loket/selesai/{kd}', [LoketController::class, 'selesai'])->name('loket.selesai');

//MANUAL
Route::post('loket/m2/panggil/{nomor}', [LoketControllerManual::class, 'panggil'])->name('loket.manual.panggil');
Route::post('loket/m2/stop/{nomor}', [LoketControllerManual::class, 'stop'])->name('loket.manual.stop');

//ANTRIAN LOKET DOBEL LOKET 1
Route::post('loket/dobel-1/panggil', [LoketDobleController::class, 'panggil1'])->name('loketdobel1.panggil1');
//ANTRIAN LOKET DOBEL LOKET 2
Route::post('loket/dobel-2/panggil', [LoketDobleController::class, 'panggil2'])->name('loketdobel1.panggil2');

//TES ANTRIAN
Route::post('antrian/tes/1', [TesAntrianController::class, 'display1'])->name('tes.antrian.display1');
Route::post('antrian/tes/2', [TesAntrianController::class, 'display2'])->name('tes.antrian.display2');
Route::post('antrian/tes/loket', [TesAntrianController::class, 'loket'])->name('tes.antrian.loket');





