<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;
    public function user(){
        return $this->morphOne(User::class , 'actor' , 'actor_type' , 'actor_id' , 'id');
    }

    public function diploma(){
        return $this->belongsTo(Diploma::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }
    public function trainerEvaluations(){
        return $this->hasMany(TrainerEvaluation::class);
    }

    public function groups(){
        return $this->belongsToMany(Group::class , 'tranier_groups');
    }
}
