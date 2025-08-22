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
        $table->string('email')->nullable()->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->string('q1')->nullable();
        $table->string('a1')->nullable();
        $table->string('q2')->nullable();
        $table->string('a2')->nullable();
        $table->enum('forgot_password_send_email', [0,1])->default(0);
        $table->string('created_by');
        $table->string('updated_by')->nullable();
        $table->timestamps();
        $table->enum('is_active', ['tidak aktif','aktif'])->default('aktif');
    }
}
