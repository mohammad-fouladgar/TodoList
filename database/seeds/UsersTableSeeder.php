<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
 
        $users = [
        	[
                'id' => 1,
                'name' => 'mohammad',
                'email' => 'mohammad@gmail.com',
                'activated' => true,
                'password' => bcrypt('123456'),
                'updated_at' => '2017-06-11 08:00:46',
                'updated_at' => '2017-06-11 08:00:46'
            ],
            [
        		'id' => 2,
        		'name' => 'shahab',
        		'email' => 'shahab@gmail.com',
        		'activated' => true,
        		'password' => bcrypt('123456'),
                'updated_at' => '2017-06-11 08:00:46',
        		'updated_at' => '2017-06-11 08:00:46'
        	],

        	
        ];

        DB::table('users')->insert($users);
    }
}
