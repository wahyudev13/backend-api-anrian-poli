<?php

namespace App\Http\Controllers;
use App\Events\PanggilLoketDoble1;
use App\Events\PanggilLoketDoble2;
use App\Models\Setting;
use Illuminate\Http\Request;

class LoketDobleController extends Controller
{

    public function text_marquee() {
        $text = Setting::select('value')->where('field', 'text_marquee')->get();
        if ($text) {
            return response()->json([
                'message'   => 'success',
                'data'      => $text
            ], 200);
        }
    }

    public function responsive_voice() {
        $text = Setting::select('value')->where('field', 'responsive_voice')->get();
        if ($text) {
            return response()->json([
                'message'   => 'success',
                'data'      => $text
            ], 200);
        }
    }

    public function panggil1(Request $request) {
        $panggil = PanggilLoketDoble1::dispatch($request->all());
        // if ($panggil) {
        //     return response()->json([
        //         'message'   => 'success panggil',
        //         'data'      => $nomor
        //     ], 200);
        // }
    }

    public function panggil2(Request $request) {
        $panggil2 = PanggilLoketDoble2::dispatch($request->all());
        // if ($panggil) {
        //     return response()->json([
        //         'message'   => 'success panggil',
        //         'data'      => $nomor
        //     ], 200);
        // }
    }
}
