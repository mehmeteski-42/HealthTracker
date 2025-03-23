<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $appointments = null;
        $medications = null;

        if (Auth::check()) {
            $appointments = DB::table('appointments')
                ->where('user_id', Auth::id())
                ->orderBy('date', 'desc')
                ->take(1)
                ->get();

            $medications = DB::table('medications')
                ->where('user_id', Auth::id())
                ->orderBy('time', 'asc')
                ->take(1)
                ->get();
        }

        return view('welcome', compact('appointments', 'medications'));
    }
}