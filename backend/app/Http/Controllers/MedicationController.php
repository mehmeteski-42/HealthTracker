<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Medication;

class MedicationController extends Controller
{
    public function index()
{
    // Retrieve medications for the authenticated user
    $medications = Medication::where('user_id', Auth::id())->get();

    // Return the medications as a JSON response
    return response()->json($medications);
}
    public function store(Request $request)
    {
    
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
    public function destroy($id)
    {
        $medication = DB::table('medications')->where('id', $id)->first();

        if (!$medication) {
            return response()->json(['message' => 'İlaç bulunamadı.'], 404);
        }

        // İlacı sil
        DB::table('medications')->where('id', $id)->delete();

        return response()->json(['message' => 'İlaç başarıyla silindi.']);
    }
}
