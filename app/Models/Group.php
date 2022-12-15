<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function getDayesStatusAttributes(){
        return $this->dayes ? 'سبت - اثنين - أربعاء' : 'أحد - ثلاثاء - خميس';
    }
    public function room(){
        return $this->belongsTo(Room::class , 'room_id' , 'id');
    }
    public function diploma(){
        return $this->belongsTo(Diploma::class);
    }
    public function trainers(){
        return $this->belongsToMany(Trainer::class , 'tranier_groups');
    }
    public function students(){
        return $this->hasMany(Student::class);
    }
    public function timelines(){
        return $this->belongsToMany(Timeline::class , 'group_timelines');
    }
}
