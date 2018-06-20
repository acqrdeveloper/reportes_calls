<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;

class Users_Queues extends Model
{
    protected $connection   = 'laravel';
    protected $table 		= 'users_queues';
    protected $primaryKey   = 'id';
    public    $timestamps   = false;

    protected $fillable = [
        'id', 'user_id', 'queue_id', 'priority',
    ];

    public function user(){
        return $this->belongsTo('Cosapi\Models\User');
    }

    public function cola(){
        return $this->belongsTo('Cosapi\Models\Queues');
    }
}
