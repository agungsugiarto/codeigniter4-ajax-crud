<?php

namespace App\Database\Seeds;

use App\Models\BookModel;
use CodeIgniter\Database\Seeder;
use Faker;

class BookSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $books = new BookModel();

        for ($i = 0; $i < 50; $i++) {
            $data = [
                'title'       => $faker->sentence,
                'author'      => $faker->name,
                'description' => $faker->realText(),
                'status'      => $faker->randomElement(['publish', 'pending', 'draft']),
            ];
            $books->save($data);
        }
    }
}
