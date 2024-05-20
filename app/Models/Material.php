<?php

namespace App\Models;

use App\Models\ItemDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function details(){

        return $this->hasMany(ItemDetails::class)->get();
    }

    public function categoryData(){

        return $this->belongsTo(Category::class)->first();
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


    public function items() {

        return $this->hasMany(DataOfInvoice::class)->get();
    }


    public function ItemDetails() {

        return $this->hasMany(ItemDetails::class)->get();
    }


    public function salePrice() {

        $itemPrice = 0;
        foreach ($this->items() as $item) {

            if($item->operation_type()=="in")
                $itemPrice = $item->sale_price;
        }

        return $itemPrice;
    }
}
