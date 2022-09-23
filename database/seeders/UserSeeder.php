<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (! User::query()->first()) {
            User::factory()->count(45)->create();
        }
    }
}
