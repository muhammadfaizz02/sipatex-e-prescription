<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResepDetail extends Model
{
    protected $table = 'resep_detail';
    protected $guarded = [];

    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obatalkes::class, 'obatalkes_id');
    }

    public function signa(): BelongsTo
    {
        return $this->belongsTo(Signa::class, 'signa_id');
    }

    public function resep(): BelongsTo
    {
        return $this->belongsTo(Resep::class);
    }
}
