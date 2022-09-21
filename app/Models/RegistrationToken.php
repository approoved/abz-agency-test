<?php

namespace App\Models;

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
}
