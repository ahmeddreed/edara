<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::create([
            'title' => "Title",
            'price' => 2000,
            'description' => fake()->text(),
            "image"=>"img/img.jpg",
            'note' =>"test note",
            'user_id' => 1,
            "category_id" => 1,
        ]);

        Material::create([
            'title' => "Title",
            'price' => 2000,
            'description' => fake()->text(),
            "image"=>"img/img.jpg",
            'note' =>"test note",
            'user_id' => 1,
            "category_id" => 1,
        ]);



        Material::create([
            'title' => "Title",
            'price' => 2000,
            'description' => fake()->text(),
            "image"=>"img/img.jpg",
            'note' =>"test note",
            'user_id' => 1,
            "category_id" => 2,
        ]);


        Material::create([
            'title' => "Title",
            'price' => 2000,
            'description' => fake()->text(),
            "image"=>"img/img.jpg",
            'note' =>"test note",
            'user_id' => 1,
            "category_id" => 2,
        ]);




        Material::create([
            'title' => "Title",
            'price' => 2000,
            'description' => fake()->text(),
            "image"=>"img/img.jpg",
            'note' =>"test note",
            'user_id' => 1,
            "category_id" => 3,
        ]);


        Material::create([
            'title' => "Title",
            'price' => 2000,
            'description' => fake()->text(),
            "image"=>"img/img.jpg",
            'note' =>"test note",
            'user_id' => 1,
            "category_id" => 3,
        ]);



        Material::create([
            'title' => "Title",
            'price' => 2000,
            'description' => fake()->text(),
            "image"=>"img/img.jpg",
            'note' =>"test note",
            'user_id' => 1,
            "category_id" => 4,
        ]);

    }
}
