<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class District extends Model
{
    use Sluggable;
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'state_id', 'slug'];

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

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function cities(){
        return $this->morphMany(City::class, 'cityable');
    }

    public function users(){
        return $this->hasMany(User::class);
    }

}
