<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function registrationPaymentsValidated(): HasMany
    {
        // Un administrateur peut valider plusieurs paiements hors plateforme.
        return $this->hasMany(RegistrationPayment::class, 'validated_by');
    }

    public function activityLogs(): HasMany
    {
        // Un administrateur peut être associé à plusieurs actions d'audit.
        return $this->hasMany(ActivityLog::class);
    }
}
