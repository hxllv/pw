<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'available',
        'price',
        'main_image'
    ];

    public function belongsToType() {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function hasManyImages() {
        return $this->hasMany(Image::class);
    }
}
