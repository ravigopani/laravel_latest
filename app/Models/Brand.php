<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $connection = 'sqlite';

    protected $table = 'brands';
    protected $primaryKey = 'brand_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $dateFormat = 'U';

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'updated_date';

    public function all_brands()
    {
        foreach (Brand::all() as $brand) {
            echo $brand->name;
        }

        $brands = Brand::where('active', 1)
        ->orderBy('name')
        ->take(10)
        ->get();

        $brand = Brand::where('name', 'FR 900')->first();

        // If you already have an instance of an Eloquent model that was retrieved from the database, you can "refresh" the model using the fresh and refresh methods
        $freshBrand = $brand->fresh();

        $brand = Brand::where('name', 'FR 900')->first();
        $brand->name = 'FR 456';
        $brand->refresh();
        $brand->name; // "FR 900"

        Brand::chunk(200, function ($brands) {
            foreach ($brands as $brand) {
                //
            }
        });

        Brand::where('status', true)
        ->chunkById(200, function ($brands) {
            $brands->each->update(['departed' => false]);
        }, $column = 'id');

        foreach (Brand::lazy() as $brand) {
            //
        }

        Flight::where('departed', true)
        ->lazyById(200, $column = 'id')
        ->each->update(['departed' => false]);
    }

}
