<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\User;
class PostTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Faker\Factory::create();
        User::create([
            'name' => 'Cesar Santana',
            'email' => 'casc.santana@gmail.com',
            'password' => bcrypt('secret')
        ]);

        $limit = 40;

        for ($i = 0; $i < $limit; $i++) {
            Post::create([ //,
                'title' => $faker->realText(40,2),
                'user_id' => 1,
                'published' => (rand(0,1) == 1),
                'description' => $faker->paragraph
            ]);
        }



        //
    }
}
