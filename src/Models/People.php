<?php

namespace Weemple\SwapiImporter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $table = 'peoples';
    protected $guarded = [];

    public function planet()
    {
        return $this->belongsTo(\App\Models\Planet::class);
    }
}
