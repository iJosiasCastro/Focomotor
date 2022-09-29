<?php

namespace App\Models;

use App\Models\Model as ModelsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Brand extends Model
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

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function models(){
        return $this->hasMany(ModelsModel::class);
    }
}
