<?php

namespace Cosapi\Models;

use Illuminate\Database\Eloquent\Model;

class UsersProfile extends Model
{
  protected $connection = 'laravel';
  protected $table = 'users_profile';
  protected $fillable = [
    'user_id', 'dni', 'telefono', 'Sexo', 'fecha_nacimiento','avatar','ubigeo_id'
  ];

}
