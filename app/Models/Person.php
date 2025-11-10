<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vote;

class Person extends Model
{
    protected $fillable = [
        'personal_id',
        'name',
        'address',
        'number_votes',
        'unique_secret_key',
    ];

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function getPrimaryKey() {
        return $this->id;
    }

    public function getSecretKey() {
        return $this->unique_secret_key;
    }

    public function getNumberVotes() {
        return $this->number_votes;
    }
}
