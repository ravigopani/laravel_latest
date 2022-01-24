<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Events\BrandDeleted;
// use App\Events\BrandSaved;

use App\Models\Product;

class Brand extends Model
{
    use HasFactory;
    // use SoftDeletes;

    // protected $connection = 'sqlite';

    protected $table = 'brands';
    // protected $primaryKey = 'custom_primary_id'; // consider primary key as these column
    // public $incrementing = true;
    // protected $keyType = 'string'; // define primary key datatype
    public $timestamps = true; // put value in created_at and updated_at if true
    // protected $dateFormat = 'U'; // set format will store on created_at and updated_at

    const CREATED_AT = 'creation_date'; // consider this column instead of 'created_at'
    const UPDATED_AT = 'updated_date'; // consider this column instead of 'updated_at'

    protected $attributes = [
        'status' => 'Active',
    ]; // auto fill if value is not given to save data

    protected $guarded = []; // mass assignment not allow if column name contain in this array
    // protected $fillable = ['column_name']; // mass assignment allow if column name contain in this array
    // protected $hidden = ['column_name']; // hide column in select query check with toArray();

    // protected $dispatchesEvents = [
    //     'saved' => BrandSaved::class,
    //     'deleted' => BrandDeleted::class,
    // ];

    // protected static function booted()
    // {
    //     static::created(function ($user) {
    //         // using closure function
    //     });
    // }

    /* Accessor */
    // public function getFirstNameAttribute($value){
    //     return ucfirst($value);
    //     return "{$this->first_name} {$this->last_name}";
    // }

    /* Mutator */
    // public function setFirstNameAttribute($value){
    //     $this->attributes['first_name'] = strtolower($value);
    // }

    // protected $casts = [
    //     'is_admin' => 'boolean',
    // ];

    /* add a new, temporary cast at runtime */
    // $user->mergeCasts([
    //     'is_admin' => 'integer',
    //     'options' => 'object',
    // ]);

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strtolower($value);
    }

    public function has_one_product(){
        return $this->hasOne(Product::class, 'brand_id', 'id');
    }
    public function latest_has_one_product(){
        return $this->hasOne(Product::class, 'brand_id', 'id')->latestOfMany();
    }
    public function older_has_one_product(){
        return $this->hasOne(Product::class, 'brand_id', 'id')->oldestOfMany();
    }
    public function custom_has_one_product(){
        return $this->hasOne(Product::class)->ofMany('id', 'max');
    }

    public function has_many_product(){
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    public function belongs_to_product(){
        return $this->belongsTo(Product::class, 'id', 'brand_id');
    }
    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function belongs_to_with_default1_product(){
        return $this->belongsTo(Product::class, 'id', 'brand_id')->withDefault([
            'name' => 'Guest Author',
        ]);
    }
    public function belongs_to_with_default2_product()
    {
        return $this->belongsTo(Product::class)->withDefault(function ($product, $post) {
            $product->name = 'Guest Author';
        });
    }

    public function has_onr_thorough(){
        return $this->hasOneThrough(
            Owner::class,
            Car::class,
            'mechanic_id', // Foreign key on the cars table...
            'car_id', // Foreign key on the owners table...
            'id', // Local key on the mechanics table...
            'id' // Local key on the cars table...
        );
    }

    public function has_many_thorough()
    {
        return $this->hasManyThrough(
            Owner::class,
            Car::class,
            'mechanic_id', // Foreign key on the cars table...
            'car_id', // Foreign key on the owners table...
            'id', // Local key on the mechanics table...
            'id' // Local key on the cars table...
        );
    }

    /* put this into your common child class - like comment class*/
    // public function commentable(){
    //     return $this->morphTo();
    // }
    /* put this into which is parent of multiple parent  - like Post or Video class*/
    // public function products(){
    //     return $this->morphMany(Product::class, 'commentable');
    // }

    // $post = Post::find(1); || $video = Video::find(1);
    // foreach ($post->comments || $video->comments as $comment) {
    // }
    
}