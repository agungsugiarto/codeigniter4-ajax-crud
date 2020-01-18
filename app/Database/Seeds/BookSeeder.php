<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker;

class BookSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $seed = [
                'title'       => $faker->sentence,
                'author'      => $faker->name,
                'description' => $faker->realText(),
                'status'      => $faker->randomElement(['publish', 'pending', 'draft']),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];

            $data[] = $seed;
        }

        $this->db->table('books')->insertBatch($data);
    }
}
