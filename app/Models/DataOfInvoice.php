<?php

namespace App\Models;

use App\Models\Invoice;
use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataOfInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice_id",
        "material_id",
        "sale_price",
        "price",
        "Qty",
        "cost_of_all",
        "equip",
        "note",

    ];

    public function material() {

        return $this->belongsTo(Material::class, 'material_id')->first();
    }

    public function invoice() {

        return $this->belongsTo(Invoice::class, 'invoice_id')->first();
    }

    public function operation_type() {

        return $this->belongsTo(Invoice::class, 'invoice_id')->first()->operation_type;
    }


}
