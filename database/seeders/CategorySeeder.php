<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            "name"=>"الملابس احجام الطبيعية",
            "section_id"=>1,
        ]);

        Category::create([
            "name"=>"الملابس احجام خاصة" ,
            "section_id"=>1,
        ]);

        Category::create([
            "name"=>"احذية احجام خاصة" ,
            "section_id"=>2,
        ]);

        Category::create([
            "name"=>"احذية احجام خاصة" ,
            "section_id"=>2,
        ]);
    }
}
