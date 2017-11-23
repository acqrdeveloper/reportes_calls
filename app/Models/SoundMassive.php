<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;

class SoundMassive extends Model
{
    protected $connection   = 'laravel';
    protected $table        = 'sound_massive';
    protected $primaryKey   = 'id';
    public    $timestamps   = false;

    protected $fillable = [
        'id', 'name_massive', 'route_massive', 'estado_id',
    ];
}
