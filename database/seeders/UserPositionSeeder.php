<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPosition\UserPosition;
use App\Models\UserPosition\UserPositionName;

class UserPositionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (UserPositionName::cases() as $positionName) {
            UserPosition::query()->updateOrCreate([
                'name' => $positionName->value
            ]);
        }
    }
}
