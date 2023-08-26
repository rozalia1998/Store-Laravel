<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Product extends Model
{
    use HasFactory;

    // protected $fillable=[
    //     'name',
    //     'description',
    //     'price',
    //     'in_stock',
    //     'category_id',
    //     'subcat_id'
    // ];

    protected $fillable = ['name', 'description', 'price', 'in_stock', 'category_id', 'subcat_id'];

    public function category(){

        return $this->BelongsTo(Category::class);

    }

    public function subcat(){

        return $this->BelongsTo(SubCategory::class);

    }

    public function orders() :BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'orderproducts')
            ->withPivot('quantity', 'price')
            ->withTimestamps();

    }

    public function getname($value){
        return ucfirst($value);
    }

    public function reviews() :HasMany{
        return $this->hasMany(Review::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
