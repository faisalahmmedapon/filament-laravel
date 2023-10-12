<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
        // 'category_id',
        'status',
    ];

public function category(){
    return $this->hasOne(Category::class,'id','category_id');
}

public function categories()
{
    return $this->belongsToMany(Category::class);
}


}
