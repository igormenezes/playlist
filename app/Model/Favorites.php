<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Favorites extends Authenticatable
{
    use Notifiable;

    public $table = 'favorites';
    public $timestamps = false;
}
