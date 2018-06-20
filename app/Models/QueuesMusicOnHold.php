<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;

class QueuesMusicOnHold extends Model
{
    protected $connection   = 'laravel';
    protected $table        = 'queues_musiconhold';
    protected $primaryKey   = 'id';
    public    $timestamps   = false;

    protected $fillable = [
        'id', 'name_music', 'mode_music', 'directory_music', 'estado_id',
    ];
}
