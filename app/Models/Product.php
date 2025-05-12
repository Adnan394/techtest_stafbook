<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category_product;

class Product extends Model
{
    protected $guarded = ['id'];

    public function categories() {
        return $this->hasMany(Category_product::class);
    }
}