<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataOfBasket extends Model
{
    use HasFactory;

    protected $fillable = [
        "basket_id",
        "material_id",
        "count",
        "note",
    ];
}
