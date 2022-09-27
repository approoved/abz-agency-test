<?php

namespace App\Models\User;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Database\Factories\UserFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\UserPosition\UserPosition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property int $position_id
 * @property string $photo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property UserPosition $position
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position_id',
        'photo',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(UserPosition::class);
    }

    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }
}
