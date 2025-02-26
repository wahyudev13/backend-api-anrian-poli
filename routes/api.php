<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoketController;
use App\Http\Controllers\LoketControllerManual;
use App\Http\Controllers\FarmasiController;
use App\Http\Controllers\TesAntrianController;

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


Route::get('/getregistered','App\Http\Controllers\RegisteredController@index');

//Cari
Route::get('/cari','App\Http\Controllers\RegisteredController@cari');

//Poli
Route::get('/getpoli','App\Http\Controllers\RegisteredController@Poliklinik');
Route::get('/poli/{kode}','App\Http\Controllers\RegisteredController@showpoli');
//Route::resource('/getregistered',RegisteredController::class);
//Antrian A
Route::post('/antrian/store','App\Http\Controllers\RegisteredController@store');
Route::post('/antrian/update/{tgl}/{norm}/{dokter}/{poli}','App\Http\Controllers\RegisteredController@update');
//Route::get('/antrian/hapus/{tgl}/{norm}/{dokter}/{poli}','App\Http\Controllers\RegisteredController@destroy');

//Antrian B
Route::post('/antrian/storeb','App\Http\Controllers\RegisteredController@storeb');
Route::post('/antrianb/update/{tgl}/{norm}/{dokter}/{poli}','App\Http\Controllers\RegisteredController@updateb');

//Antrian C
Route::post('/antrian/storec','App\Http\Controllers\RegisteredController@storec');
Route::post('/antrianc/update/{tgl}/{norm}/{dokter}/{poli}','App\Http\Controllers\RegisteredController@updatec');
//Antrian D
Route::post('/antrian/stored','App\Http\Controllers\RegisteredController@stored');
Route::post('/antriand/update/{tgl}/{norm}/{dokter}/{poli}','App\Http\Controllers\RegisteredController@updated');
//Antrian E
Route::post('/antrian/storee','App\Http\Controllers\RegisteredController@storee');
Route::post('/antriane/update/{tgl}/{norm}/{dokter}/{poli}','App\Http\Controllers\RegisteredController@updatee');
//Antrian F
Route::post('/antrian/storef','App\Http\Controllers\RegisteredController@storef');
Route::post('/antrianf/update/{tgl}/{norm}/{dokter}/{poli}','App\Http\Controllers\RegisteredController@updatef');

//ANTRIAN LOKET
Route::get('loket/get', [LoketController::class, 'get'])->name('loket.get');
Route::post('loket/panggil/{kd}', [LoketController::class, 'panggil'])->name('loket.panggil');
Route::post('loket/stop/{kd}', [LoketController::class, 'stop'])->name('loket.stop');
Route::post('loket/lewati/{kd}', [LoketController::class, 'lewati'])->name('loket.lewati');
Route::post('loket/selesai/{kd}', [LoketController::class, 'selesai'])->name('loket.selesai');

//MANUAL
Route::post('loket/m2/panggil/{nomor}', [LoketControllerManual::class, 'panggil'])->name('loket.manual.panggil');
Route::post('loket/m2/stop/{nomor}', [LoketControllerManual::class, 'stop'])->name('loket.manual.stop');

//Farmasi ANTRIAN A
Route::get('farmasi/nomor/nomor-a/get', [FarmasiController::class, 'getNomorA'])->name('farmasi.nomora.get');
Route::get('farmasi/nomor/antrian-a/get', [FarmasiController::class, 'getAntrianA'])->name('farmasi.antriana.get');
Route::post('farmasi/nomor/antrian-a/tambah', [FarmasiController::class, 'tambahA'])->name('farmasi.antriana.store');

//FARMASI ANTRIAN B
Route::get('farmasi/nomor/nomor-b/get', [FarmasiController::class, 'getNomorB'])->name('farmasi.nomorb.get');
Route::get('farmasi/nomor/antrian-b/get', [FarmasiController::class, 'getAntrianB'])->name('farmasi.antrianb.get');
Route::post('farmasi/nomor/antrian-b/tambah', [FarmasiController::class, 'tambahB'])->name('farmasi.antrianb.store');

//ANTRIAN FARMAMSI A DAN B
Route::post('farmasi/nomor/antrian-a/panggil/{id}', [FarmasiController::class, 'panggilA'])->name('farmasi.antriana.panggil');
Route::post('farmasi/nomor/antrian-a/stop/{id}', [FarmasiController::class, 'stopA'])->name('farmasi.antriana.stop');
Route::post('farmasi/nomor/antrian-a/lewati/{id}', [FarmasiController::class, 'lewati'])->name('farmasi.antriana.lewati');
Route::post('farmasi/nomor/antrian-a/selesai/{id}', [FarmasiController::class, 'selesai'])->name('farmasi.antriana.selesai');
//23-11-2014
Route::post('farmasi/nomor/antrian/proses/{id}', [FarmasiController::class, 'proses'])->name('farmasi.antriana.proses');
Route::get('farmasi/nomor/antrian/proses/get', [FarmasiController::class, 'getProses'])->name('farmasi.antriana.proses.get');

//23-11-2014
//ANTRIAN LOKET DOBEL LOKET 1
Route::post('loket/dobel-1/panggil', [LoketDobleController::class, 'panggil1'])->name('loketdobel1.panggil1');
//ANTRIAN LOKET DOBEL LOKET 2
Route::post('loket/dobel-2/panggil', [LoketDobleController::class, 'panggil2'])->name('loketdobel1.panggil2');
//TEXT DISPLAY LOKET
Route::get('loket/text_marquee', [LoketDobleController::class, 'text_marquee'])->name('loket.text_marquee');
//ENABLE RESPONSIVE VOICE
Route::get('loket/responsive-voice', [LoketDobleController::class, 'responsive_voice'])->name('loket.responsive_voice');


//TES ANTRIAN
Route::post('antrian/tes/1', [TesAntrianController::class, 'index'])->name('tes.antrian.index');
Route::post('antrian/tes/loket', [TesAntrianController::class, 'loket'])->name('tes.antrian.loket');



