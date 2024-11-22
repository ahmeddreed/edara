<?php

namespace App\Models;

use App\Models\AdsImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'img',
        'copy_right',
        'des',
        'phone1',
        'phone2',
    ];


    public function ads(){

        return $this->hasMany(AdsImage::class);
    }
}
