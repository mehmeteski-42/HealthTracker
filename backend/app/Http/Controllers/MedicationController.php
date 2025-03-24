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
        return view('medications', compact('medications', 'appointments'));
    }
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
