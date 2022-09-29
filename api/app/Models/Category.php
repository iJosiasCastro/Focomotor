<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
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

    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }

    public function brands(){
        return $this->hasMany(Brand::class);
    }
}
