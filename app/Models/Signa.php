<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signa extends Model
{
    protected $table = 'signa_m';
    protected $primaryKey = 'signa_id';
    protected $guarded = [];
    public $timestamps = false;

    public function resepDetails()
    {
        return $this->hasMany(ResepDetail::class, 'signa_id');
    }
}
