<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;

class QueueAnnounce extends Model
{
    protected $connection   = 'laravel';
    protected $table        = 'queues_announce';
    protected $primaryKey   = 'id';
    public    $timestamps   = false;

    protected $fillable = [
        'id', 'route_announce',
    ];
}
