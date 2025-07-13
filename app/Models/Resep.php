<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resep extends Model
{
    protected $table = 'resep';
    protected $guarded = [];

    public function details(): HasMany
    {
        return $this->hasMany(\App\Models\ResepDetail::class, 'resep_id');
    }

    public function isRacikan(): bool
    {
        return $this->jenis === 'racikan';
    }
}
