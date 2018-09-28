<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;

class SoundMassive extends Model
{
    protected $connection   = 'laravel';
    protected $table        = 'sound_massive';
    public    $timestamps   = false;

    protected $fillable = [
        'id', 'name_massive','state_masive', 'route_massive', 'state_ivr',
    ];
}
