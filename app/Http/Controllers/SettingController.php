<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PoliSik;

class SettingController extends Controller
{
    public function showPoliUsed(Request $request)
    {
        $setting = DB::connection('mysql2')
            ->table('antrian_setting')
            ->where('module', 'general')
            ->where('field', 'poli_digunakan')
            ->first();

        $currentValue = $setting?->value ?? 'U0005,INT';
        
        // Get polyclinics from sik_new_141023 database
        $polyclinics = PoliSik::getAllPolyclinics();

        return view('settings.poli', [
            'value' => $currentValue,
            'polyclinics' => $polyclinics,
        ]);
    }

    public function savePoliUsed(Request $request)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:255',
        ]);

        DB::connection('mysql2')
            ->table('antrian_setting')
            ->updateOrInsert(
                ['module' => 'general', 'field' => 'poli_digunakan'],
                ['value' => $validated['value']]
            );

        return redirect()->route('settings.poli.show')->with('status', 'Pengaturan POLI_DIGUNAKAN tersimpan.');
    }

    public function showTextMarquee(Request $request)
    {
        $setting = DB::connection('mysql2')
            ->table('antrian_setting')
            ->where('module', 'loket')
            ->where('field', 'text_marquee')
            ->first();

        $currentValue = $setting?->value ?? 'Selamat datang di Rumah Sakit PKU Sekapuk';
        
        return view('settings.text_marquee', [
            'value' => $currentValue,
        ]);
    }

    public function saveTextMarquee(Request $request)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:500',
        ]);

        DB::connection('mysql2')
            ->table('antrian_setting')
            ->updateOrInsert(
                ['module' => 'loket', 'field' => 'text_marquee'],
                ['value' => $validated['value']]
            );

        return redirect()->route('settings.text_marquee.show')->with('status', 'Pengaturan Text Marquee Loket tersimpan.');
    }
}


