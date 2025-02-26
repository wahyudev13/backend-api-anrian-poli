<?php

namespace App\Http\Controllers;
use App\Events\TesAntrianA;
use App\Events\TesAntrianLoket;
use Illuminate\Http\Request;

class TesAntrianController extends Controller
{
    public function index(Request $request) 
    {
        
        TesAntrianA::dispatch($request->all());
        
    }
    public function loket(Request $request) 
    {
        TesAntrianLoket::dispatch($request->all());
    }
}
