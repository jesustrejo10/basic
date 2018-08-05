<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminUser extends Authenticatable
{
  use Notifiable;

  protected $fillable = [
      'name',
      'email',
      'password'
  ];


  /**
   * estos datos son sensibles por lo que cuando haces select *, al colocarlos en este array no seran devueltos.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token',
  ];

}
