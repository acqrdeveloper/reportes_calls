<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $connection   = 'laravel';
    protected $table        = 'messages';

    public function user()
    {
        return $this->belongsTo('Cosapi\Models\User');
    }

    public function estado()
    {
        return $this->belongsTo('Cosapi\Models\State');
    }
}
