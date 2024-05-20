<?php

namespace App\Models;

use App\Models\Section;
use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        "section_id",
    ];

    public function section(){

        return $this->belongsTo(Section::class)->first()->name;
    }

    public function materials(){

        return $this->hasMany(Material::class)->latest()->paginate(10);
    }

}
