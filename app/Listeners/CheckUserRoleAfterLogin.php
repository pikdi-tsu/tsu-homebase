<?php

namespace App\Listeners;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class CheckUserRoleAfterLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        /** @var Authenticatable $user */
        $user = $event->user;

        // Cek apakah user punya model dan method yang kita butuhkan
        if (method_exists($user, 'hasAnyRole')) {
            if ($user->hasAnyRole(['admin', 'superadmin'])) {
                $user->last_login_at = now();
                $user->save();
            } else {
                request()->session()->flash('error', 'Anda tidak memiliki hak akses untuk masuk.');
                Auth::logout();
            }
        }
    }
}
