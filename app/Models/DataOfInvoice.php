<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataOfInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice_id",
        "material_id",
        "count",
        "note",
    ];
}
