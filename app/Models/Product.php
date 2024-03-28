<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'user_id',
        'product_title',
        'product_description',
        'product_price',
        'image_path',
        'slug',
        'category_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function parentCategory()
    {
        return $this->category->parent();
    }

    public function grandParentCategory()
    {
        return $this->parentCategory->parent();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('quantity', 'price');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }


    /**
     * @param $value
     * @return void
     * Laravel mutator product description initial capital
     */
    public function setProductDescriptionAttribute($value): void
    {
        $this->attributes['product_description'] = ucwords($value);
    }

    /**
     * @param $value
     * @return float
     * Laravel accessor product price decimal removal
     */
    public function getProductPriceAttribute($value): float
    {
        return floor((int)$value);
    }
}
