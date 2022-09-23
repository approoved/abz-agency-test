<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User\User;
use Illuminate\Support\Arr;
use App\Services\Kraken\Kraken;
use Illuminate\Support\Facades\Storage;
use App\Models\UserPosition\UserPosition;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\Kraken\Exceptions\InvalidUrlException;

final class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * @throws InvalidUrlException
     */
    public function definition(): array
    {
        $userPositions = UserPosition::all();
        $positionsIds = Arr::pluck($userPositions, 'id');

        $kraken = new Kraken();

        $optimizedPhoto = $kraken->optimizeImageUrl('https://thispersondoesnotexist.com/image');
        $path = 'images/' . uniqid() . '.jpeg';
        Storage::disk('public')->put($path, $optimizedPhoto);

        return [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+38000' . fake()->randomNumber(7),
            'position_id' => fake()->randomElement($positionsIds),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'photo' => Storage::url($path),
        ];
    }
}
