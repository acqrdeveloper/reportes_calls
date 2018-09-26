<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;

class ColaVip extends Model
{
  protected $connection = 'laravel';
  protected $table = 'queue_list_vip';
  protected $fillable = [
    'name',
    'number_telephone',
    'queue_id',
  ];
  public $timestamps = false;
}