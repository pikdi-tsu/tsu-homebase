<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request): Response
    {
        // Tentukan tujuan default berdasarkan peran pengguna
        $defaultRedirect = Auth::user()->hasAnyRole(['admin', 'super admin'])
            ? '/admin'
            : '/dashboard';

        // Arahkan pengguna ke URL yang sebelumnya ingin diakses,
        // atau ke tujuan default jika tidak ada.
        return redirect()->intended($defaultRedirect);
    }
}
