<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name"=>"manager",
            "email"=>"manager@gmail.com",
            "password"=>"$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",//password
            "gender"=>"male",
            "image"=>"img/user.jpg",
            "role_id"=>1,//manager
        ]);

        User::create([
            "name"=>"supervisor",
            "email"=>"supervisor@gmail.com",
            "password"=>"$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",//password
            "gender"=>"male",
            "image"=>"img/user.jpg",
            "role_id"=>2,//supervisor
        ]);

        User::create([
            "name"=>"staff",
            "email"=>"staff@gmail.com",
            "password"=>"$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",//password
            "gender"=>"male",
            "image"=>"img/user.jpg",
            "role_id"=>3,//staff
        ]);

        User::create([
            "name"=>"equipped",
            "email"=>"equipped@gmail.com",
            "password"=>"$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",//password
            "gender"=>"male",
            "image"=>"img/user.jpg",
            "role_id"=>4,//equipped
        ]);
    }
}
