<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable;
    //

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function leaves(){
        return $this->hasMany('App\Leave', 'emp_id', 'id');
    }
}
