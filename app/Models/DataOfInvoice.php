<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataOfInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice_id",
        "material_id",
        "price",
        "Qty",
        "cost_of_all",
        "equip",
        "note",

    ];

    public function material() {

        return $this->belongsTo(Material::class, 'material_id')->first();
        // return  Material::find($this->material_id);
    }
}
