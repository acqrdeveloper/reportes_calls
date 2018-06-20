<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;

class Queues extends Model
{
    protected $connection   = 'laravel';
    protected $table        = 'queues';
    protected $primaryKey   = 'id';
    public    $timestamps   = false;

    protected $fillable = [
        'id', 'name', 'vdn', 'queues_strategy_id', 'queues_priority_id', 'queues_music_id', 'estado_id', 'limit_call_waiting', 'queues_template_id',
    ];

    public function estrategia(){
        return $this->belongsTo('Cosapi\Models\QueueStrategy','queues_strategy_id');
    }

    public function prioridad(){
        return $this->belongsTo('Cosapi\Models\QueuePriority','queues_priority_id');
    }

    public function music(){
        return $this->belongsTo('Cosapi\Models\QueueMusic','queues_music_id');
    }

    public function announce(){
        return $this->belongsTo('Cosapi\Models\QueueAnnounce','queues_announce_id');
    }

    public function template(){
        return $this->belongsTo('Cosapi\Models\QueuesTemplate','queues_template_id');
    }
}
