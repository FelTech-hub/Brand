<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'car_models';
    protected $primaryKey = 'id';

    // A Car model belong to a car
    public function cars(){
        return $this->belongsTo(Car::class);
    }

}
