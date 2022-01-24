<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function has_one_brand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
}
