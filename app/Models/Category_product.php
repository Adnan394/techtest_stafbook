<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Category_product extends Model
{
    protected $guarded = ['id'];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}