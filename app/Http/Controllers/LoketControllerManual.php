<?php

namespace App\Http\Controllers;
use App\Events\PanggilLoketManual;
use App\Events\StopLoketManual;
use Illuminate\Http\Request;

class LoketControllerManual extends Controller
{
    public function panggil($nomor) {
        $panggil = PanggilLoketManual::dispatch($nomor);
        if ($panggil) {
            return response()->json([
                'message'   => 'success panggil',
                'data'      => $nomor
            ], 200);
        }
    }

    public function stop($nomor) {
        $stop = StopLoketManual::dispatch($nomor);
        if ($stop) {
            return response()->json([
                'message'   => 'success stop',
                'data'      => $stop
            ], 200);
        }
    }
}
