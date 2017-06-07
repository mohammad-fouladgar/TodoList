<?php

use Illuminate\Database\Seeder;

class TodolistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      	DB::table('todolists')->delete();

        $todolists = [
        	[
        		'user_id' => 1,
        		'title' => 'products step',
        		'description' => 'init products step for shop',
        		'status' => 'new',
        		'created_at' => '2017-06-07 10:00:00',
        		'updated_at' => '2017-06-07 10:00:00'
        	],

        	[
        		'user_id' => 1,
        		'title' => 'user step',
        		'description' => 'init user step for login and register',
        		'status' => 'new',
        		'created_at' => '2017-06-08 10:00:00',
        		'updated_at' => '2017-06-08 10:00:00'
        	],

        	[
        		'user_id' => 1,
        		'title' => 'catalog step',
        		'description' => 'init catalog step',
        		'status' => 'new',
        		'created_at' => '2017-06-08 12:00:00',
        		'updated_at' => '2017-06-08 12:00:00'
        	],

        	[
        		'user_id' => 1,
        		'title' => 'stock step',
        		'description' => 'init stock step',
        		'status' => 'new',
        		'created_at' => '2017-06-08 15:30:00',
        		'updated_at' => '2017-06-08 15:30:00'
        	],

        	[
        		'user_id' => 2,
        		'title' => 'designe auth views',
        		'description' => 'init designe auth views',
        		'status' => 'new',
        		'created_at' => '2017-06-09 16:30:00',
        		'updated_at' => '2017-06-09 16:30:00'
        	],
        ];

        DB::table('todolists')->insert($todolists);
    }
}
