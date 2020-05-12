<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker;

class BookSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('status')->insertBatch([
            [
                'status'      => 'Publish',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'status'      => 'Pending',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'status'      => 'Draft',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ]);

        $faker = Faker\Factory::create();

        for ($i = 0; $i < 1000; $i++) {
            $seed = [
                'title'       => $faker->sentence,
                'author'      => $faker->name,
                'description' => $faker->realText(),
                'status_id'   => $faker->randomElement(['1', '2', '3']),
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];

            $data[] = $seed;
        }

        $this->db->table('books')->insertBatch($data);
    }
}
