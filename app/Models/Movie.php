<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "note",
        "category_id",
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
