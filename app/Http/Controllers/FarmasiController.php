<?php

namespace App\Http\Controllers;
use App\Models\Farmasi;
use Carbon\Carbon;
use App\Events\PanggilAntrianFarmasiA;
use App\Events\StopAntrianFarmasiA;
use App\Events\LewatiAntrianFarmasiA;
use Illuminate\Http\Request;

class FarmasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getNomorA() {
        $todayDate = Carbon::now()->format('Y-m-d');
        $get = Farmasi::where('ketegori','A')->where('post_date',$todayDate)->get();
        $count = $get->count();

        $noantrian = $count;
        if($noantrian > 0) {
            $next_antrian = $noantrian + 1;
        } else {
            $next_antrian = 1;
        }

        return response()->json([
            'message'   => 'success',
            'data'      => $next_antrian
        ], 200);
    }

    public function getNomorB() {
        $todayDate = Carbon::now()->format('Y-m-d');
        $get = Farmasi::where('ketegori','B')->where('post_date',$todayDate)->get();
        $count = $get->count();

        $noantrianb = $count;
        if($noantrianb > 0) {
            $next_antrianb = $noantrianb + 1;
        } else {
            $next_antrianb = 1;
        }

        return response()->json([
            'message'   => 'success',
            'data'      => $next_antrianb
        ], 200);
    }

    public function getAntrianA() {
        $todayDate = Carbon::now()->format('Y-m-d');
        $get = Farmasi::whereNotIn('status',[4])
        ->where('ketegori','A')->where('post_date',$todayDate)->get();
        return response()->json([
            'message'   => 'success',
            'data'      => $get
        ], 200);
    }

    public function getAntrianB() {
        $todayDate = Carbon::now()->format('Y-m-d');
        $get = Farmasi::whereNotIn('status',[4])
        ->where('ketegori','B')->where('post_date',$todayDate)->get();
        return response()->json([
            'message'   => 'success',
            'data'      => $get
        ], 200);
    }

    public function tambahA(Request $request) {
        $todayDate = Carbon::now()->format('Y-m-d');
        $cek_status = Farmasi::where('ketegori','A')
        ->where('no_urut', $request->nourut)
        ->where('post_date', $todayDate)
        ->count();
        if ($cek_status > 0) {
            return response()->json([
                'message'   => 'error',
                'data'      => 'NOMOR ANTRIAN ADA YANG SAMA'
            ], 400);
        }else {
            $tambahA = Farmasi::create([
                'no_urut' => $request->nourut,
                'ketegori' => 'A',
                'status' => 0,
                'post_date' => $todayDate
    
            ]);
          
            return response()->json([
                'message'   => 'success',
                'data'      => $tambahA
            ], 200);
        }
    }

    public function tambahB(Request $request) {
        $todayDate = Carbon::now()->format('Y-m-d');
        $cek_status = Farmasi::where('ketegori','B')
        ->where('no_urut', $request->nourut)
        ->where('post_date', $todayDate)
        ->count();
        if ($cek_status > 0) {
            return response()->json([
                'message'   => 'error',
                'data'      => 'NOMOR ANTRIAN ADA YANG SAMA'
            ], 400);
        }else {
            $tambahA = Farmasi::create([
                'no_urut' => $request->nourut,
                'ketegori' => 'B',
                'status' => 0,
                'post_date' => $todayDate
    
            ]);
          
            return response()->json([
                'message'   => 'success',
                'data'      => $tambahA
            ], 200);
        }
    }

    public function panggilA($id) {
        $todayDate = Carbon::now()->format('Y-m-d');
        
        $kategori = Farmasi::where('id', $id)->first();

        $cari_terpanggil = Farmasi::whereNotIn('id',[$id])->where('status',1)
        ->where('post_date', $todayDate)
        ->count();

        if ($cari_terpanggil > 0) {
            return response()->json([
                'message'   => 'error',
                'data'      => 'STOP ANTRIAN YANG SUDAH TERPANGGIL TERLEBIH DAHULU'
            ], 400);
        }else {
            $update = Farmasi::where('id', $id)->where('post_date', $todayDate)->update([
                'status' => 1,
            ]);

            $get_data =  Farmasi::where('id', $id)->where('post_date', $todayDate)->first();
            PanggilAntrianFarmasiA::dispatch($get_data);
    
            return response()->json([
                'message'   => 'success',
                'data'      => $update
            ], 200);
        }
    }

    public function stopA($id) {
        $todayDate = Carbon::now()->format('Y-m-d');

        $kategori = Farmasi::where('id', $id)->first();

        $cek_status = Farmasi::where('ketegori',$kategori->ketegori)
        ->where('id', $id)->where('post_date', $todayDate)->first();

        if ($cek_status->status == 0 || $cek_status->status == 2 || $cek_status->status == 3) {
            return response()->json([
                'message'   => 'error',
                'data'      => 'ANTRIAN '.$cek_status->no_urut.' BELUM TERPANGGIL'
            ], 400);
        }else {
            $stop = Farmasi::where('id', $id)->where('post_date', $todayDate)->update([
                'status' => 2,
            ]);

            $get_data =  Farmasi::where('id', $id)->where('post_date', $todayDate)->first();
            StopAntrianFarmasiA::dispatch($get_data);
    
            return response()->json([
                'message'   => 'success',
                'data'      => $stop
            ], 200);
        }
    }

    public function lewati($id) {
        $todayDate = Carbon::now()->format('Y-m-d');
        $cari_lewati = Farmasi::where('id', $id)->where('status',3)->where('post_date', $todayDate)->count();
        $cek_status = Farmasi::where('id', $id)->where('post_date', $todayDate)->first();
        if ($cari_lewati > 0) {
            return response()->json([
                'message'   => 'error',
                'data'      => 'ANTRIAN '.$cek_status->no_urut.'SUDAH PERNAH DILEWATI'
            ], 400);
        }elseif ($cek_status->status == 0) {
            return response()->json([
                'message'   => 'error',
                'data'      => 'ANTRIAN '.$cek_status->no_urut.' BELUM TERPANGGIL'
            ], 400);
        }else {
            $lewati = Farmasi::where('id', $id)->where('post_date', $todayDate)->update([
                'status' => 3,
            ]);
    
            $get_data =  Farmasi::where('id', $id)->where('post_date', $todayDate)->first();

            LewatiAntrianFarmasiA::dispatch($get_data);
    
            return response()->json([
                'message'   => 'success',
                'data'      => $lewati
            ], 200);
        }
    }

    public function selesai($id) {
        $todayDate = Carbon::now()->format('Y-m-d');
        $selesai = Farmasi::where('id', $id)->where('post_date', $todayDate)->update([
            'status' => 4,
        ]);

        return response()->json([
            'message'   => 'success',
            'data'      => $selesai
        ], 200);   
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
    public function store(Request $request)
    {
        $todayDate = Carbon::now()->format('Y-m-d');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
