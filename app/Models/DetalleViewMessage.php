<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleViewMessage extends Model
{
    protected $connection   = 'laravel';
    protected $table        = 'detail_view_message';

    public function state()
    {
        return $this->belongsTo('Cosapi\Models\StateMessage', 'state_message_id');
    }

    public function user()
    {
        return $this->belongsTo('Cosapi\Models\User');
    }
}
