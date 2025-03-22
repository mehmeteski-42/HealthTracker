<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Medication;

class MedicationController extends Controller
{
    public function store(Request $request)
    {
        // Validasyon
        $request->validate([
            'medicationName' => 'required|string|max:100',
            'medicationTime' => 'required|date_format:H:i',
            'additional_notes' => 'nullable|string|max:255',
        ]);

        // Randevuyu kaydet
        DB::table('medications')->insert([
            'user_id' => Auth::id(),
            'name' => $request->medicationName,
            'time' => $request->medicationTime,
            'additional_notes' => $request->additional_notes,
        ]);
        
        //TODO
        return response()->json(['message' => 'İlaç başarıyla kaydedildi!']);
    }
}
