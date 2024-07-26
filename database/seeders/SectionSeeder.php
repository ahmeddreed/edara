<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create([
            "name"=>"الملابس",
            "user_id"=>1,
        ]);

        Section::create([
            "name"=>"احذية" ,
            "user_id"=>1,
            ]);

        Section::create([
            "name"=>"جنط" ,
            "user_id"=>1,
        ]);

    }
}
