<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserDosenTendik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'module_name' => 'required', // Opsional: nama perangkat yg request token
        ]);

        // 2. Cari user berdasarkan email
        $user = UserDosenTendik::where('email', $request->email)->first();

        // 3. Periksa user dan password
        if (! $user || ! Hash::check($request->password, $user->password)) {
            // Jika salah, kirim pesan error
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan salah.'],
            ]);
        }

        // 4. Jika berhasil, buat dan kirimkan token
        return response()->json([
            'message' => 'Login berhasil',
            'token' => $user->createToken($request->module_name)->plainTextToken
        ]);
    }
}
