<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table-> dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
            $table->dropColumn('password');

            $table->string('phone');
            $table->unsignedBigInteger('position_id');
            $table->string('photo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table-> timestamp('email_verified_at');
            $table->string('remember_token');
            $table->string('password');

            $table->dropColumn('phone');
            $table->dropColumn('position_id');
            $table->dropColumn('photo');
        });
    }
};
