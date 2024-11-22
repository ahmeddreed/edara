<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice_type",
        "operation_type",
        "user_id",
        "customer_id",
        "t_price",
        "discount",
        "equipper",
        "t_price_after_discount",
        "material_count",
        "note",
    ];

    public function items() {

        return $this->hasMany(DataOfInvoice::class)->get();
    }

    public function equipinvoice() {

        $itemEquipCount = 0;
        foreach ($this->items() as $item) {
            if($item->equip)
                $itemEquipCount++;
        }

        return $itemEquipCount == count($this->items());
    }

    public function customer() {

        return  $this->belongsTo(Customer::class)->first();
    }

    public function user() {

        return $this->belongsTo(User::class)->first();
    }

    public function confirm() {

        // return ConfirmTheInvoice::find($this->id);
        return $this->hasOne(ConfirmTheInvoice::class,"invoice_id")->first();
    }

    public function materialCount(){//get count of material

        $totalMaterial=0 ;
        foreach ($this->items() as $item) {
            $totalMaterial += $item->Qty;
        }

        return $totalMaterial;
    }

    public function totalCost(){//get count of material

        $totalCost=0 ;
        foreach ($this->items() as $item) {
            $totalCost += $item->cost_of_all;
        }

        return $totalCost;
    }



}
