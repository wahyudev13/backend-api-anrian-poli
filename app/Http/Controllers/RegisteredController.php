<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Registered;
use App\Models\Antrian;
use App\Models\Poli;
use App\Events\AntrianPoliA;
use App\Events\AntrianPoliB;
use App\Events\AntrianPoliC;
use App\Events\AntrianPoliD;
use App\Events\AntrianPoliE;
use App\Events\AntrianPoliF;
use Carbon\Carbon;

class RegisteredController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();

        $get = Registered::join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
        ->join('dokter','reg_periksa.kd_dokter','=','dokter.kd_dokter')
        ->select('reg_periksa.tgl_registrasi','reg_periksa.no_reg','reg_periksa.no_rawat','reg_periksa.no_rkm_medis','reg_periksa.kd_dokter','reg_periksa.kd_poli','pasien.nm_pasien','poliklinik.nm_poli','dokter.nm_dokter')
        ->where('reg_periksa.tgl_registrasi',$today)
        ->orderby('reg_periksa.no_rawat','desc')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Pasien',
            'data' => $get
        ],200);
       
    }
    public function cari(Request $request)
    {
        $today = Carbon::today();
        $cari = $request->cari;
        $get = Registered::join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
        ->join('dokter','reg_periksa.kd_dokter','=','dokter.kd_dokter')
        ->select('reg_periksa.tgl_registrasi','reg_periksa.no_reg','reg_periksa.no_rawat','reg_periksa.no_rkm_medis','reg_periksa.kd_dokter','reg_periksa.kd_poli','pasien.nm_pasien','poliklinik.nm_poli','dokter.nm_dokter')
        ->where('reg_periksa.kd_poli','like',"%".$cari."%")
        ->where('reg_periksa.tgl_registrasi',$today)
        ->orderby('reg_periksa.no_rawat','asc')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Pasien',
            'data' => $get
        ],200);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //Function Panggilan A
    public function store(Request $request)
    {
        AntrianPoliA::dispatch($request->all());
    }
    //Function Panggilan B
    public function storeb(Request $request)
    {
        AntrianPoliB::dispatch($request->all());   
    }
    //Function Panggilan C
    public function storec(Request $request)
    {
        AntrianPoliC::dispatch($request->all());
    }
    //Function Panggilan D
    public function stored(Request $request)
    {
        AntrianPoliD::dispatch($request->all());
    }
    //Function Panggilan E
    public function storee(Request $request)
    {
        AntrianPoliE::dispatch($request->all());
    }
    //Function Panggilan E
    public function storef(Request $request)
    {
        AntrianPoliF::dispatch($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tgl, $norm, $dokter, $poli)
    {
        AntrianPoliA::dispatch($request->all());   
    }
    public function updateb(Request $request, $tgl, $norm, $dokter, $poli)
    {
        AntrianPoliB::dispatch($request->all());
    }

    public function updatec(Request $request, $tgl, $norm, $dokter, $poli)
    {
        AntrianPoliC::dispatch($request->all());   
    }
    public function updated(Request $request, $tgl, $norm, $dokter, $poli)
    {
        AntrianPoliD::dispatch($request->all());   
    }
    public function updatee(Request $request, $tgl, $norm, $dokter, $poli)
    {
        AntrianPoliE::dispatch($request->all());   
    }
    public function updatef(Request $request, $tgl, $norm, $dokter, $poli)
    {
        AntrianPoliF::dispatch($request->all());   
    }

    
    public function Poliklinik()
    {
        $getPoli = Poli::get();

        return response()->json([
            'success' => true,
            'message' => 'Data Poliklinik',
            'data' => $getPoli
        ],200);

    }
}
