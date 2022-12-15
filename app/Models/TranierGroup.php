<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranierGroup extends Model
{
    use HasFactory;
    public function traner_groups(){
        return $this->hasMany(Groub::class , Tranier::class ,'tranier_groups');
    }
}
