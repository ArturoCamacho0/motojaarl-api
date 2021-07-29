<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function provider(){
        return $this->belongsTo(Provider::class);
    }


    public function prices(){
        return $this->belongsToMany(Price::class);
    }

    public function sales(){
        return $this->belongsToMany(Sale::class);
    }
}
