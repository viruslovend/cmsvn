<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset the users table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();

        // generate 2 users/author
        $faker = Factory::create();

        DB::table('users')->insert([
            [
                'name' => "Tiến Lực",
                'slug' => 'tien-luc',
                'email' => "tienluc90@gmail.com",
                'password' => bcrypt('anhluc'),
                'bio' => $faker->text(rand(250, 300))
            ],
            [
                'name' => "Thiên Vũ",
                'slug' => 'thien-vu',
                'email' => "thienvu@gmail.com",
                'password' => bcrypt('thienvu'),
                'bio' => $faker->text(rand(250, 300))
            ],
			[
                'name' => "Thiên Vân",
                'slug' => 'thien-van',
                'email' => "thienvan@gmail.com",
                'password' => bcrypt('thienvan'),
                'bio' => $faker->text(rand(250, 300))
            ],
        ]);
    }
}
