<?php

namespace App\Http\Controllers;
use App\Events\TesAntrianA;
use App\Events\TesAntrianB;
use App\Events\TesAntrianLoket;
use Illuminate\Http\Request;

class TesAntrianController extends Controller
{
    public function display1(Request $request) 
    {
        
        TesAntrianA::dispatch($request->all());
        
    }
    public function display2(Request $request) 
    {
        
        TesAntrianB::dispatch($request->all());
        
    }
    public function loket(Request $request) 
    {
        TesAntrianLoket::dispatch($request->all());
    }
}
