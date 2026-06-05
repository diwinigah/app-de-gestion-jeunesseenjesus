<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProjectInvestorInterestStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectInvestorInterest extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'investor_user_id',
        'intended_amount',
        'committed_amount',
        'currency',
        'status',
        'message',
        'admin_notes',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'intended_amount' => 'decimal:2',
        'committed_amount' => 'decimal:2',
        'status' => ProjectInvestorInterestStatus::class,
    ];

    public function project(): BelongsTo
    {
        // Chaque intérêt de financement concerne un projet unique.
        return $this->belongsTo(Project::class);
    }

    public function investorUser(): BelongsTo
    {
        // Chaque intérêt de financement est porté par un investisseur authentifié.
        return $this->belongsTo(InvestorUser::class);
    }

    public function scopeByStatus(Builder $query, ProjectInvestorInterestStatus|string $status): Builder
    {
        return $query->where('status', $status instanceof ProjectInvestorInterestStatus ? $status->value : $status);
    }
}
