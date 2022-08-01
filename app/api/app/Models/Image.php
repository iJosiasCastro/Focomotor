<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'order', 'vehicle_id'];
    public $timestamps = false;

    // protected $primaryKey = ['order', 'vehicle_id'];
    // public $incrementing = false;


    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
}
