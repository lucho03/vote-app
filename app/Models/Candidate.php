<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Party;
use App\Models\Vote;

class Candidate extends Model
{
    protected $fillable = [
        'name',
        'party_id',
        'reference_number'
    ];

    public function party() {
        return $this->belongsTo(Party::class);
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }
}
