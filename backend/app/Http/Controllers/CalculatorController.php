<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalculatorController extends Controller
{
    public function index()
    {
        $appointments = null;
        $medications = null;
        
        if(Auth::check()){
            $appointments = DB::table('appointments')
            ->where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();
        }
        if(Auth::check()){
            $medications = DB::table('medications')
                ->where('user_id', Auth::id())
                ->orderBy('time', 'asc')
                ->get();
        }
        return view('calculators', compact('appointments', 'medications'));
    }
}