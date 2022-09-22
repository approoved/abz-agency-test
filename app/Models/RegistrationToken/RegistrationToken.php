<?php

namespace App\Models\RegistrationToken;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $token
 * @property bool $revoked
 * @property Carbon $expired_at
 * @property Carbon|null $created_at
 * @property carbon|null $updated_at
 */
class RegistrationToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'revoked',
        'expired_at',
    ];

    public function revoke(): void
    {
        $this->delete();
    }
}
