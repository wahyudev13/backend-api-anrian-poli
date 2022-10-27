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
        ->orderby('reg_periksa.no_rawat','desc')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Pasien',
            'data' => $get
        ],200);
    }
    public function showpoli($kode)
    {
        $today = Carbon::today();

        $get = Registered::join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
        ->join('dokter','reg_periksa.kd_dokter','=','dokter.kd_dokter')
        // ->join('antripoli_custom','reg_periksa.no_rawat','=','antripoli_custom.no_rawat')
        ->select('reg_periksa.tgl_registrasi','reg_periksa.no_reg','reg_periksa.no_rawat','reg_periksa.no_rkm_medis','reg_periksa.kd_dokter','reg_periksa.kd_poli','pasien.nm_pasien','poliklinik.nm_poli','dokter.nm_dokter')
        ->where('reg_periksa.tgl_registrasi',$today)
        ->where('reg_periksa.kd_poli',$kode)
        ->orderby('reg_periksa.no_rawat','desc')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Pasien',
            'data' => $get
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'kd_dokter'     => 'required',
            'kd_poli'   => 'required',
            'status'   => 'required',
            'no_rawat'   => 'required',
            'no_reg' => 'required',
            'no_rkm_medis' => 'required'
         ]);

         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }

        $count = Antrian::where('no_rawat',$request->no_rawat)->where('status','1')->count();
        if ($count > 0) {
           alert('Pasien Sudah Pernah dipanggil, Klik Tombol STOP Dahulu');
        }else {
            $simpan = Antrian::insert([
                'kd_dokter' => $request->kd_dokter,
                'kd_poli' => $request->kd_poli,
                'status' => $request->status,
                'no_rawat' => $request->no_rawat,
                'no_reg' => $request->no_reg,
                'no_rkm_medis' => $request->no_rkm_medis,
                'tgl' => $request->tgl_registrasi
            ]);
    
            AntrianPoliA::dispatch($request->all());
        }

        
    }
    //Function Panggilan B
    public function storeb(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kd_dokter'     => 'required',
            'kd_poli'   => 'required',
            'status'   => 'required',
            'no_rawat'   => 'required',
            'no_reg' => 'required',
            'no_rkm_medis' => 'required'
         ]);

         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }

        $count = Antrian::where('no_rawat',$request->no_rawat)->where('status','1')->count();
        if ($count > 0) {
           alert('Pasien Sudah Pernah dipanggil, Klik Tombol STOP Dahulu');
        }else {
            $simpan = Antrian::insert([
                'kd_dokter' => $request->kd_dokter,
                'kd_poli' => $request->kd_poli,
                'status' => $request->status,
                'no_rawat' => $request->no_rawat,
                'no_reg' => $request->no_reg,
                'no_rkm_medis' => $request->no_rkm_medis,
                'tgl' => $request->tgl_registrasi
            ]);

            AntrianPoliB::dispatch($request->all());

            // return response()->json([
            //             'success' => true,
            //             'message' => 'Berhasil',
            //             'data' => $simpan
            //         ], 200);
    
            
        }

        
    }
    //Function Panggilan C
    public function storec(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kd_dokter'     => 'required',
            'kd_poli'   => 'required',
            'status'   => 'required',
            'no_rawat'   => 'required',
            'no_reg' => 'required',
            'no_rkm_medis' => 'required'
         ]);

         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }

        $count = Antrian::where('no_rawat',$request->no_rawat)->where('status','1')->count();
        if ($count > 0) {
           alert('Pasien Sudah Pernah dipanggil, Klik Tombol STOP Dahulu');
        }else {
            $simpan = Antrian::insert([
                'kd_dokter' => $request->kd_dokter,
                'kd_poli' => $request->kd_poli,
                'status' => $request->status,
                'no_rawat' => $request->no_rawat,
                'no_reg' => $request->no_reg,
                'no_rkm_medis' => $request->no_rkm_medis,
                'tgl' => $request->tgl_registrasi
            ]);

            AntrianPoliC::dispatch($request->all());

            // return response()->json([
            //             'success' => true,
            //             'message' => 'Berhasil',
            //             'data' => $simpan
            //         ], 200);
    
            
        }

        
    }
    //Function Panggilan D
    public function stored(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kd_dokter'     => 'required',
            'kd_poli'   => 'required',
            'status'   => 'required',
            'no_rawat'   => 'required',
            'no_reg' => 'required',
            'no_rkm_medis' => 'required'
         ]);

         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }

        $count = Antrian::where('no_rawat',$request->no_rawat)->where('status','1')->count();
        if ($count > 0) {
           alert('Pasien Sudah Pernah dipanggil, Klik Tombol STOP Dahulu');
        }else {
            $simpan = Antrian::insert([
                'kd_dokter' => $request->kd_dokter,
                'kd_poli' => $request->kd_poli,
                'status' => $request->status,
                'no_rawat' => $request->no_rawat,
                'no_reg' => $request->no_reg,
                'no_rkm_medis' => $request->no_rkm_medis,
                'tgl' => $request->tgl_registrasi
            ]);

            AntrianPoliD::dispatch($request->all());

            // return response()->json([
            //             'success' => true,
            //             'message' => 'Berhasil',
            //             'data' => $simpan
            //         ], 200);
    
            
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$tglreg, $noreg)
    {
        // $panggil = Registered::where('no_rkm_medis',$id)
        // ->where('tgl_registrasi',$tglreg)
        // ->where('no_reg',$noreg)
        // ->first();

        // $panggil = Registered::join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        // ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
        // ->select('reg_periksa.no_reg','pasien.nm_pasien','poliklinik.nm_poli')
        // ->where('reg_periksa.no_rkm_medis',$id)
        // ->where('reg_periksa.tgl_registrasi',$tglreg)
        // ->where('reg_periksa.no_reg',$noreg)
        // ->first();
       

        // if ($panggil) {
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Success!!!',
        //         'data' => $panggil
        //     ], 200);
        // }else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Error, Tidak Ditemukan',
        //         'data' => ''
        //     ], 200);
        // }
        

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = Validator::make($request->all(), [
            'status'   => 'required',
         ]);

         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
         }

        $update = Antrian::where('tgl',$tgl)
        ->where('no_rkm_medis',$norm)
        ->where('kd_dokter',$dokter)
        ->where('kd_poli',$poli)
        ->update([
            'status' => $request->status
        ]);

        if ($update) {
            AntrianPoliA::dispatch($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Berhasil DiUpdate!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal DiUpdate!',
            ], 400);
        }

        
    }
    public function updateb(Request $request, $tgl, $norm, $dokter, $poli)
    {
        $validator = Validator::make($request->all(), [
            'status'   => 'required',
        ]);

        if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
        }

        $update = Antrian::where('tgl',$tgl)
        ->where('no_rkm_medis',$norm)
        ->where('kd_dokter',$dokter)
        ->where('kd_poli',$poli)
        ->update([
            'status' => $request->status
        ]);

        if ($update) {
            AntrianPoliB::dispatch($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Berhasil DiUpdate!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal DiUpdate!',
            ], 400);
        }

        
    }

    public function updatec(Request $request, $tgl, $norm, $dokter, $poli)
    {
        $validator = Validator::make($request->all(), [
            'status'   => 'required',
        ]);

        if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
        }

        $update = Antrian::where('tgl',$tgl)
        ->where('no_rkm_medis',$norm)
        ->where('kd_dokter',$dokter)
        ->where('kd_poli',$poli)
        ->update([
            'status' => $request->status
        ]);

        if ($update) {
            AntrianPoliC::dispatch($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Berhasil DiUpdate!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal DiUpdate!',
            ], 400);
        }

        
    }
    public function updated(Request $request, $tgl, $norm, $dokter, $poli)
    {
        $validator = Validator::make($request->all(), [
            'status'   => 'required',
        ]);

        if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
        }

        $update = Antrian::where('tgl',$tgl)
        ->where('no_rkm_medis',$norm)
        ->where('kd_dokter',$dokter)
        ->where('kd_poli',$poli)
        ->update([
            'status' => $request->status
        ]);

        if ($update) {
            AntrianPoliD::dispatch($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Berhasil DiUpdate!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal DiUpdate!',
            ], 400);
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tgl, $norm, $dokter, $poli)
    {
        // $hapus = Antrian::where('tgl',$tgl)
        // ->where('no_rkm_medis',$norm)
        // ->where('kd_dokter',$dokter)
        // ->where('kd_poli',$poli)
        // ->delete();

        // if ($hapus) {
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Berhasil Dihapus!',
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Gagal Dihapus!',
        //     ], 400);
        // }
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
