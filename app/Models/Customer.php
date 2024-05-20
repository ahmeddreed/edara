<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        "phone",
        "address",
        "manager",
        "governorate",
    ];



    public function invoices(){

        return $this->hasMany(Invoice::class)->get();
    }

    public function account(){

        return $this->hasOne(CustomerAccount::class)->first();
    }

    public function updateCostOfAccount($totalCost){

        $account = CustomerAccount::where("customer_id",$this->id)->first();
        $account->total_cost = $totalCost;
        $account->update();

    }

}
