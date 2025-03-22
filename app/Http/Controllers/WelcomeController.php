<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $appointments = [];
        $medications = [];
        if (Auth::check()) {
            // Mevcut veritabanından randevuları al
            $appointments = DB::table('appointments')
                ->where('user_id', Auth::id())
                ->get();

            $medications = DB::table('medications')
                ->where('user_id', Auth::id())
                ->get();
        }
        return view('welcome', compact('appointments', 'medications'));
    }
}