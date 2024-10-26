<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Post;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //khoi tao faker
        $faker = Faker::create();
        //chay vong lap
            //xac dinh so ban ghi va kieu du lieu
        for($i = 0; $i < 50; $i++){
            Post::create ([
                'title' => $faker -> sentence(6, true),
                'body' => $faker -> paragraph(3, true)
            ]);
        }
    }
}
