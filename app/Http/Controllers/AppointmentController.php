<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        // Validasyon
        $request->validate([
            'doctorName' => 'required|string|max:100',
            'appointmentTime' => 'required|date_format:H:i',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        // Randevuyu kaydet
        Appointment::create([
            'user_id' => Auth::id(),
            'name' => $request->doctorName,
            'time' => $request->appointmentTime,
            'departmant' => $request->department,
            'location' => $request->location,
        ]);

        return response()->json(['message' => 'Randevu başarıyla kaydedildi!']);
    }
}
