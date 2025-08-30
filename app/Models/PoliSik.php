<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PoliSik extends Model
{
    protected $connection = 'mysql';
    protected $table = 'poliklinik';
    
    // Disable timestamps if the table doesn't have them
    public $timestamps = false;
    
    /**
     * Get all polyclinics from the sik_new_141023 database that don't exist in antrian_setting
     */
    public static function getAllPolyclinics()
    {
        try {
            // Get existing polyclinic codes from antrian_setting database
            $existingCodes = DB::connection('mysql2')
                ->table('antrian_setting')
                ->where('module', 'general')
                ->where('field', 'poli_digunakan')
                ->value('value');
            
            $existingCodesArray = [];
            if ($existingCodes) {
                $existingCodesArray = array_map('trim', explode(',', $existingCodes));
            }
            
            // Get all polyclinics from sik_new_141023 database
            $allPolyclinics = DB::connection('mysql')
                ->table('poliklinik')
                ->select('kd_poli', 'nm_poli')
                ->orderBy('nm_poli', 'asc')
                ->get();
            
            // Filter out existing ones
            $filteredPolyclinics = $allPolyclinics->filter(function($poli) use ($existingCodesArray) {
                return !in_array($poli->kd_poli, $existingCodesArray);
            });
            
            return $filteredPolyclinics->values();
            
        } catch (\Exception $e) {
            // Return empty collection if connection fails
            return collect([]);
        }
    }
    
    /**
     * Get polyclinic by kode
     */
    public static function getByKode($kode)
    {
        try {
            return DB::connection('mysql')
                ->table('poliklinik')
                ->where('kd_poli', $kode)
                ->first();
        } catch (\Exception $e) {
            return null;
        }
    }
    
    /**
     * Get all polyclinics (including existing ones) for reference
     */
    public static function getAllPolyclinicsWithStatus()
    {
        try {
            // Get existing polyclinic codes from antrian_setting database
            $existingCodes = DB::connection('mysql2')
                ->table('antrian_setting')
                ->where('module', 'general')
                ->where('field', 'poli_digunakan')
                ->value('value');
            
            $existingCodesArray = [];
            if ($existingCodes) {
                $existingCodesArray = array_map('trim', explode(',', $existingCodes));
            }
            
            // Get all polyclinics from sik_new_141023 database
            $allPolyclinics = DB::connection('mysql')
                ->table('poliklinik')
                ->select('kd_poli', 'nm_poli')
                ->orderBy('nm_poli', 'asc')
                ->get();
            
            // Add status to each polyclinic
            $polyclinicsWithStatus = $allPolyclinics->map(function($poli) use ($existingCodesArray) {
                $poli->is_existing = in_array($poli->kd_poli, $existingCodesArray);
                return $poli;
            });
            
            return $polyclinicsWithStatus;
            
        } catch (\Exception $e) {
            // Return empty collection if connection fails
            return collect([]);
        }
    }
}
