<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserDosenTendik;
use App\Models\UserMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Endpoint untuk login Dosen & Tendik.
     */
    public function loginDosenTendik(Request $request)
    {
        // Panggil mesin login dengan model UserDosenTendik
        return $this->attemptLogin($request, UserDosenTendik::class);
    }

    /**
     * Endpoint untuk login Mahasiswa.
     */
    public function loginMahasiswa(Request $request)
    {
        // Panggil mesin login dengan model UserMahasiswa
        return $this->attemptLogin($request, UserMahasiswa::class);
    }

    private function attemptLogin(Request $request, string $modelClass)
    {
        // 1. Validasi request (sama untuk semua)
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'module_name' => 'required|string', // Nama perangkat yg request token
        ]);

        // 2. Cari user berdasarkan email MENGGUNAKAN MODEL DINAMIS
        $user = $modelClass::where('email', $request->email)->first();

        // 3. Periksa user dan password (sama untuk semua)
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan salah.'],
            ]);
        }

        // 4. Jika berhasil, buat dan kirimkan token (sama untuk semua)
        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user, // Opsional: kirim data user
            'token' => $user->createToken($request->module_name)->plainTextToken
        ]);
    }
}
