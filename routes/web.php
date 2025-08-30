<?php
use App\Events\AntrianPoliA;
use App\Events\Train;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\LoginController;
// use App\Http\Controllers\VideoSettingController;
use App\Http\Controllers\VideoDisplaySettingController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\SettingController;

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

Route::get('/login', [LoginController::class, 'showLogin'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Test route for polyclinic data (remove in production)
Route::get('/test-polyclinics', function() {
    try {
        $availablePolyclinics = \App\Models\PoliSik::getAllPolyclinics();
        $allPolyclinicsWithStatus = \App\Models\PoliSik::getAllPolyclinicsWithStatus();
        
        return response()->json([
            'success' => true,
            'available_count' => $availablePolyclinics->count(),
            'total_count' => $allPolyclinicsWithStatus->count(),
            'available' => $availablePolyclinics->take(10), // Show first 10 available
            'all_with_status' => $allPolyclinicsWithStatus->take(10) // Show first 10 with status
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});


Route::middleware('webauth')->group(function () {
    Route::get('/', function () {
        return view('menu.index');
      
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Video upload via web
    Route::get('/videos/upload', [VideoController::class, 'showUploadForm'])->name('videos.upload.form');

    Route::post('/videos/upload', [VideoController::class, 'upload'])->name('videos.upload.submit');
    Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');

    // Video display settings
    Route::get('/video/display-settings', [VideoDisplaySettingController::class, 'index'])->name('video.display.index');
    Route::post('/video/display-settings', [VideoDisplaySettingController::class, 'store'])->name('video.display.store');
    Route::delete('/video/display-settings/{videoDisplaySetting}', [VideoDisplaySettingController::class, 'destroy'])->name('video.display.destroy');

	// API Key management
	Route::get('/security/api-key', [ApiKeyController::class, 'show'])->name('security.api_key.show');
	Route::post('/security/api-key/generate', [ApiKeyController::class, 'generate'])->name('security.api_key.generate');

    // Settings: POLI_DIGUNAKAN
    Route::get('/settings/poli', [SettingController::class, 'showPoliUsed'])->name('settings.poli.show');
    Route::post('/settings/poli', [SettingController::class, 'savePoliUsed'])->name('settings.poli.save');

    // Settings: Text Marquee Loket
    Route::get('/settings/text-marquee', [SettingController::class, 'showTextMarquee'])->name('settings.text_marquee.show');
    Route::post('/settings/text-marquee', [SettingController::class, 'saveTextMarquee'])->name('settings.text_marquee.save');
});


// Route::get('/broadcast', function () {
//    broadcast(new App\Events\Train());
// });

// Route::post('/antrian/store','App\Http\Controllers\RegisteredController@store');
