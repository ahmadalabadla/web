<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public function city(){
        return $this->belongsTo(City::class);
    }
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function diploma(){
        return $this->belongsTo(Diploma::class);
    }
    public function finance(){
        return $this->belongsTo(Finance::class);
    }
    public function paids(){
        return $this->hasMany(Paid::class);
    }
    public function student_evaluations(){
        return $this->hasMany(Student_evaluation::class);
    }
    public function activity_record(){
        return $this->hasMany(Activity_record::class);
    }
    public function follow_up_notbook(){
        return $this->hasMany(Follow_up_notbook::class);
    }

    public function condition(){
        return $this->hasMany(Condition::class);
    }

    // public function getStatusAttribute()
    // {
    //     // return $this->status ? "active" : "blackList" : "finished";
          
    //     if ($this->status == 'active'){
    //         return $this->status;
    //     }
    //     elseif ($this->status == 'blackList'){
    //         return $this->status;
    //     }
    //     elseif ($this->status == 'finished'){
    //         return $this->status;
    //     }

    // }

}
