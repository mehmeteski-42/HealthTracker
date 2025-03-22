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
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Kullanıcı oluşturma
        User::create([
            'username' => $request->username,
            'password' => $request->password,
        ]);

        // Welcome sayfasına yönlendirme
        return redirect('/')->with('success', 'Kayıt başarılı! Lütfen giriş yapın.');
    }
}