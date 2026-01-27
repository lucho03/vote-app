<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Vote;

class Person extends Model
{
    protected $fillable = [
        'person_id',
        'pin_hash',
        'public_key',
        'private_key',
    ];

    // protected $hidden = [
    //     'pin_hash',
    //     'private_key'
    // ];

    public function setPin(string $pin): void {
        $this->pin_hash = Hash::make($pin);
    }

    public function verifyPin(string $pin): bool {
        return Hash::check($pin, $this->pin_hash);
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function getPrimaryKey() {
        return $this->id;
    }
}
