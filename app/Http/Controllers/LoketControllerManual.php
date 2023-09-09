<?php

namespace App\Http\Controllers;
use App\Events\PanggilLoketManual;
use Illuminate\Http\Request;

class LoketControllerManual extends Controller
{
    public function panggil($nomor) {
        $panggil = PanggilLoketManual::dispatch($nomor);
        if ($panggil) {
            return response()->json([
                'message'   => 'success',
                'data'      => $nomor
            ], 200);
        }
    }
}
