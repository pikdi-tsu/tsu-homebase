<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // 1. Import HTTP Client
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginDosenTendik(Request $request)
    {
        // Panggil proxy dengan provider untuk dosen/tendik
        return $this->proxyLogin($request, 'dosen_tendik');
    }

    public function loginMahasiswa(Request $request)
    {
        // Panggil proxy dengan provider untuk mahasiswa
        return $this->proxyLogin($request, 'mahasiswa');
    }

    private function proxyLogin(Request $request, string $provider)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // 2. Buat request internal ke endpoint /oauth/token milik Passport
        $response = Http::asForm()->post(config('app.url').'/oauth/token', [
            'grant_type' => 'password',
            'client_id' => config('passport.password_grant_client.id'),
            'client_secret' => config('passport.password_grant_client.secret'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
            'provider' => $provider, // <-- Kirim provider yang benar
        ]);

        // 3. Jika gagal, kirimkan error yang sesuai
        if ($response->failed()) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan salah.'],
            ]);
        }

        // 4. Jika berhasil, teruskan respons dari Passport (berisi token)
        return $response->json();
    }

    public function logout(Request $request)
    {
        // Ambil token yang sedang digunakan untuk request ini, lalu cabut (revoke)
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Logout berhasil'], 200);
    }
}
