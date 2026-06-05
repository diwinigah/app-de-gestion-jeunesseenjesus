<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CampEditionStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CampEdition extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'year',
        'description',
        'registration_open_at',
        'registration_close_at',
        'camp_start_date',
        'camp_end_date',
        'total_price',
        'currency',
        'status',
        'is_active',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'registration_open_at' => 'datetime',
        'registration_close_at' => 'datetime',
        'camp_start_date' => 'date',
        'camp_end_date' => 'date',
        'total_price' => 'decimal:2',
        'status' => CampEditionStatus::class,
        'is_active' => 'boolean',
    ];

    public function registrations(): HasMany
    {
        // Une édition de camp regroupe plusieurs inscriptions publiques.
        return $this->hasMany(Registration::class);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', CampEditionStatus::Open->value);
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->where('status', CampEditionStatus::Archived->value);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
