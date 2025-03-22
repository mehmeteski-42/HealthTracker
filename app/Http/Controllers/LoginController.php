<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth/login');
    }

    public function log_in(Request $request)
    {
        // ... Form doğrulama
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        // ... Kullanıcı doğrulama
        $user = User::where('name', $request->name)->first();

        // Şifreyi düz metin olarak kontrol et
        if (!$user || $request->password !== $user->password) {
            return back()->with('error', 'Kullanıcı adı veya şifre hatalı.');
        }

        /* Auth::login($user); */

        // ... Oturum açma
        $request->session()->regenerate();

        return redirect('/');
    }
}