<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class State extends Model
{
    use Sluggable;
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'slug'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }  

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function users(){
        return $this->hasMany(User::class);
    }
    
    public function districts(){
        return $this->hasMany(District::class);
    }

    public function cities(){
        return $this->morphMany(City::class, 'cityable');
    }

    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }

}
