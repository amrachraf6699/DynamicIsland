<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TeamMemberRelation extends Model
{
    use HasFactory;

    protected $table = 'team_memberables';

    protected $fillable = [
        'team_member_id',
        'memberable_id',
        'memberable_type',
        'role',
    ];

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function memberable(): MorphTo
    {
        return $this->morphTo();
    }
}
