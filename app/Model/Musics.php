<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Musics extends Authenticatable
{
    use Notifiable;

    public $table = 'musics';
    public $timestamps = false;
}
