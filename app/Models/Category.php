<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [

        'category_name',
        'parent_id',
    ];


    public function children(){
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function recursiveDelete(){       
        foreach ($this->children as $child) {
            $child->recursiveDelete();
        }
        $this->delete();

    }

    public function ancestors()
    {
        return $this->parent ? $this->parent->ancestors()->concat([$this->parent]) : collect([]);
    }

    public function getLevelAttribute()
    {
        return $this->ancestors()->count();
    }

}
