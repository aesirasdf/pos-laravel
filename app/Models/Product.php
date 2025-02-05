<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name", "description", "price", "barcode", "category_id", "extension"
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    
    public function transactions(){
        return $this->belongsToMany(Transaction::class)->withPivot("quantity", "price");
    }
}
