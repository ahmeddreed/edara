<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = [
        "price",
        "title",
        "description",
        "image",
        "user_id",
        "category_id",
        "note",
    ];
}
