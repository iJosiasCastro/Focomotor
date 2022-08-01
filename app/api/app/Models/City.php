<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class City extends Model
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

    public function cityable(){
        return $this->morphTo();
    }
    
    // public function state(){
    //     return $this->belongsTo(State::class);
    // }
}
