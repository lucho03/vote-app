<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = [
        'name',
        'reference_number'
    ];
    
    public function candidates() {
        return $this->hasMany(Candidate::class);
    }

    public function getDisplayName() {
        return "{$this->name} ({$this->reference_number})";
    }

    public function getSlug() {
        return strtolower(str_replace(' ', '-', $this->name));
    }
}
