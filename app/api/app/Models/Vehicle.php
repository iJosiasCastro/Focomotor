<?php

namespace App\Models;

use App\Models\Model as ModelsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Vehicle extends Model
{
    use Sluggable;
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'price',
        'year',
        'mileage',
        'description',
        'thumbnail',

        'fuel_id',

        'category_id',
        'brand_id',
        'model_id',

        'user_id'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
      
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function fuel(){
        return $this->belongsTo(Fuel::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function model(){
        return $this->belongsTo(ModelsModel::class);
    }

    public function images(){
        return $this->hasMany(Image::class)->select('id', 'vehicle_id', 'name');
    }

    public function user(){
        return $this->belongsTo(User::class)->select(['id', 'name', 'slug', 'email', 'whatsapp', 'state_id', 'city_id', 'district_id', 'role_id', 'phone']);
    }
}
