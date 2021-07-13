<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Car extends Model
{
    use HasFactory;
    protected $table = 'cars';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'founded', 'description', 'image_path','user_id'];

    protected $hidden = ['updated_at'];
    protected $visible = ['id', 'name', 'founded', 'description', 'image_path', 'user_id'];

    public function carmodels(){
        return $this->hasMany(CarModel::class);
    }

    public function headquater(){
        return $this->hasOne(Headquaters::class);
    }
    
    //Define hasManyThrough Relationship
    public function engines(){
        return $this->hasManyThrough(
            Engine::class,
            CarModel::class,
            'car_id', //Foreign key on CarModel table
            'model_id' //Foreign key on Engine table

        );
    }

    //Define a hasOneThrough Relationship
    public function productionDate(){
        return $this->HasOneThrough(
            CarProduction::class,
            CarModel::class,
            'car_id',
            'model_id'
        );
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
