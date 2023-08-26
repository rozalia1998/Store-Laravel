<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable=['category_id','name'];

    public function category() :BelongsTo {

        $this->BelongsTo(Category::class);

    }

    public function products() :hasMany {

        return $this->hasMany(Product::class);

    }

    public function images(){

        return $this->morphOne(Image::class,'imageable');

    }

}
