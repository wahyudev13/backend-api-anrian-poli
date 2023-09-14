<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoketController;
use App\Http\Controllers\LoketControllerManual;
use App\Http\Controllers\FarmasiController;

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

//Farmasi
Route::get('farmasi/nomor/nomor-a/get', [FarmasiController::class, 'getNomorA'])->name('farmasi.nomora.get');
Route::get('farmasi/nomor/antrian-a/get', [FarmasiController::class, 'getAntrianA'])->name('farmasi.antriana.get');
Route::post('farmasi/nomor/antrian-a/tambah', [FarmasiController::class, 'tambahA'])->name('farmasi.antriana.store');
Route::post('farmasi/nomor/antrian-a/panggil/{id}', [FarmasiController::class, 'panggilA'])->name('farmasi.antriana.panggil');
Route::post('farmasi/nomor/antrian-a/stop/{id}', [FarmasiController::class, 'stopA'])->name('farmasi.antriana.stop');
Route::post('farmasi/nomor/antrian-a/lewati/{id}', [FarmasiController::class, 'lewati'])->name('farmasi.antriana.lewati');
Route::post('farmasi/nomor/antrian-a/selesai/{id}', [FarmasiController::class, 'selesai'])->name('farmasi.antriana.selesai');

//ANtrian B
Route::get('farmasi/nomor/nomor-b/get', [FarmasiController::class, 'getNomorB'])->name('farmasi.nomorb.get');
Route::get('farmasi/nomor/antrian-b/get', [FarmasiController::class, 'getAntrianB'])->name('farmasi.antrianb.get');
Route::post('farmasi/nomor/antrian-b/tambah', [FarmasiController::class, 'tambahB'])->name('farmasi.antrianb.store');



