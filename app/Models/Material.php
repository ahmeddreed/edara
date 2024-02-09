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

    public function user(){

        return $this->belongsTo(User::class)->first()->name;
    }


    public function category(){

        return $this->belongsTo(Category::class)->first()->name;
    }

    // public function number(){

    //     return $this->hasOne(NumberOfMaterial::class)->first()->number;
    // }


    public function number(){

        $num = 0;
        $data = $this->hasOne(NumberOfMaterial::class)->first();

        if($data != null)

            $num = $data->number;
        else

            $num = 0;

        return $num;
    }
}
