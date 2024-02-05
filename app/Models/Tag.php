<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $fillable = [
        'product_id',
        'tag_name',
    ];

    public function productAds(){
        return $this->belongsTo(Product::class, 'product_ads');
    }
}