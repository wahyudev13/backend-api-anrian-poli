<?php

namespace App\Http\Controllers;

use App\Models\Loket;
use Carbon\Carbon;
use App\Events\PanggilLoket;
use App\Events\StopAntrian;
use App\Events\LewatiAntrian;
use Illuminate\Http\Request;

class LoketController extends Controller
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

    public function get() {
        $todayDate = Carbon::now()->format('Y-m-d');
        $show = Loket::whereNotIn('status',[4])->where('postdate',$todayDate)->orderBy('start_time','asc')->get();
        return response()->json([
            'message'   => 'Data Nomor Antrian Loket',
            'data'      => $show
        ], 200);
    }

    public function panggil($kd) {
        $todayDate = Carbon::now()->format('Y-m-d');

        $cari_terpanggil = Loket::where('status',1)->where('postdate', $todayDate)
        ->count();

        if ($cari_terpanggil > 0) {
            return response()->json([
                'message'   => 'error',
                'data'      => 'STOP ANTRIAN YANG SUDAH TERPANGGIL TERLEBIH DAHULU'
            ], 400);
        }else {
            $panggil = Loket::where('postdate', $todayDate)->where('kd', $kd)->update([
                'status' => 1,
            ]);
            if ($panggil) {
                $get_data =  Loket::where('postdate', $todayDate)->where('kd', $kd)->first();
                PanggilLoket::dispatch($get_data);
                
                return response()->json([
                    'message'   => 'success',
                    'data'      => $get_data
                ], 200);
            }else {
                return response()->json([
                    'message'   => 'error',
                    'data'      => 'STOP ANTRIAN YANG TERPANGGIL DAHULU'
                ], 400);
            }
        }
    }

    public function stop($id) {
        $todayDate = Carbon::now()->format('Y-m-d');
        $cek_status = Loket::where('kd', $id)->where('postdate', $todayDate)->first();
        if ($cek_status->status == 0 || $cek_status->status == 2) {
            return response()->json([
                'message'   => 'error',
                'data'      => 'ANTRIAN BELUM TERPANGGIL'
            ], 400);
        }else {
            $stop = Loket::where('kd', $id)->where('postdate', $todayDate)->update([
                'status' => 2,
            ]);

            $get_data =  Loket::where('kd', $id)->where('postdate', $todayDate)->first();
            StopAntrian::dispatch($get_data);
    
            return response()->json([
                'message'   => 'success',
                'data'      => $get_data
            ], 200);
        }
    }

    public function lewati($id) {
        $todayDate = Carbon::now()->format('Y-m-d');
        $cari_lewati = Loket::where('kd', $id)->where('status',3)->where('postdate', $todayDate)->count();
        $cek_status = Loket::where('kd', $id)->where('postdate', $todayDate)->first();
        if ($cari_lewati > 0) {
            return response()->json([
                'message'   => 'error',
                'data'      => 'ANTRIAN SUDAH PERNAH DILEWATI'
            ], 400);
        }elseif ($cek_status->status == 0) {
            return response()->json([
                'message'   => 'error',
                'data'      => 'ANTRIAN BELUM TERPANGGIL'
            ], 400);
        }else {
            $lewati = Loket::where('kd', $id)->where('postdate', $todayDate)->update([
                'status' => 3,
            ]);
    
            $get_data =  Loket::where('kd', $id)->where('postdate', $todayDate)->first();
            LewatiAntrian::dispatch($get_data);
    
            return response()->json([
                'message'   => 'success',
                'data'      => $get_data
            ], 200);
        }
    }

    public function selesai($id)  {
        $todayDate = Carbon::now()->format('Y-m-d');
        $selesai = Loket::where('kd', $id)->where('postdate', $todayDate)->update([
            'status' => 4,
        ]);

        return response()->json([
            'message'   => 'success',
            'data'      => $selesai
        ], 200);
    }
}
