<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Party;
use App\Models\Candidate;
use App\Models\Person;

class Vote extends Model
{
    protected $fillable = [
        'candidate_id',
        'person_id',
    ];

    public function candidate() {
        return $this->belongsTo(Candidate::class);
    }

    public function person() {
        return $this->belongsTo(Person::class);
    }
}
