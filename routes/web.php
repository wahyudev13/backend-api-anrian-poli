<?php
use App\Events\AntrianPoliA;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test-broadcast-event', function () {
//     AntrianPoliA::dispatch('parameter atribut message | sangcahaya.id');
    
//     echo 'test broadcast event sangcahaya.id';
// });
