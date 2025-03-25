<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        // Register sayfasını döndürür
        return view('auth/register');
    }

    public function store(Request $request)
    {
        // Form doğrulama
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        // Kullanıcı oluşturma
        User::create([
            'name' => $request->name,
            'password' => $request->password,
        ]);

        // Welcome sayfasına yönlendirme
        return response()->json([
            'success' => true,
            'message' => 'Kayıt başarılı! Lütfen giriş yapın.'
        ]);
    }
}