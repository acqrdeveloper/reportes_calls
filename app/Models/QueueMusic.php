<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;

class QueueMusic extends Model
{
    protected $connection   = 'laravel';
    protected $table        = 'queues_music';
    protected $primaryKey   = 'id';
    public    $timestamps   = false;

    protected $fillable = [
        'id', 'name_music', 'route_music',
    ];
}
