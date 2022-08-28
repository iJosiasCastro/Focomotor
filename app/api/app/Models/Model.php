<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Cviebrock\EloquentSluggable\Sluggable;

class Model extends EloquentModel
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

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    
    public function vehicles(){
        return $this->hasMany(Vehicle::class);
    }
}
