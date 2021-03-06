<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    public function type(){
        return $this->belongsTo('App\LeaveType')->select('id', 'type_name');
    }

    public function employee(){
        return $this->belongsTo('App\Employee', 'emp_id', 'id')->select('id', 'name');
    }
}
