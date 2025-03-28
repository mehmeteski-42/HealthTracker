<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
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
        return view('appointments', compact('appointments', 'medications'));

    }
    public function store(Request $request)
    {
        //echo '<script> console.log("'.$request->all().'") </script>';
        // Validasyon
        $request->validate([
            'doctorName' => 'required|string|max:100',
            'appointmentTime' => 'required|date_format:H:i',
            'date' => 'required|string|max:10',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        // Randevuyu kaydet
        DB::table('appointments')->insert([
            'user_id' => Auth::id(),
            'doctor_name' => $request->doctorName,
            'time' => $request->appointmentTime,
            'date' => $request->date,
            'department' => $request->department,
            'location' => $request->location,
        ]);
        
        //TODO
        return response()->json(['message' => 'Randevu başarıyla kaydedildi!']);
    }
    public function destroy($id)
    {
        $appointment = DB::table('appointments')->where('id', $id)->first();

        if (!$appointment) {
            return response()->json(['message' => 'Randevu bulunamadı.'], 404);
        }

        // Randevuyu sil
        DB::table('appointments')->where('id', $id)->delete();

        return response()->json(['message' => 'Randevu başarıyla silindi.']);
    }
}
