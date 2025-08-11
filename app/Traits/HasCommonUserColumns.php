<?php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;

trait HasCommonUserColumns
{
    /**
     * Adds common user columns to the table.
     *
     * @param Blueprint $table
     * @return void
     */
    protected function addCommonUserColumns(Blueprint $table): void
    {
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->string('q1');
        $table->string('a1');
        $table->string('q2');
        $table->string('a2');
        $table->string('forgot_password_send_email');
        $table->string('created_by');
        $table->string('updated_by');
        $table->timestamps();
        $table->string('is_active');
    }
}
