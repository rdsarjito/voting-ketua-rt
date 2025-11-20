<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'voting_start',
        'voting_end',
        'is_active',
    ];

    protected $casts = [
        'voting_start' => 'datetime',
        'voting_end' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function isVotingOpen(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        
        if ($this->voting_start && $now->lt($this->voting_start)) {
            return false;
        }
        
        if ($this->voting_end && $now->gt($this->voting_end)) {
            return false;
        }
        
        return true;
    }
}
