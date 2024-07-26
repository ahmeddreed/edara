<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            "title"=>"Edara",
            "img"=>"img/hero.png",
            "copy_right"=>"Create By AAM company @2024 copy right",
            "des"=>"نظام ادارة الامور المالة و الادارية والمهام اليومة للشركة",
        ]);

    }
}
