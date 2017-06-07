<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->delete();

        $tasks = [
        	[
        		'todolist_id' => 1,
        		'title' => 'info product',
        		'description' => 'init info product',
        		'status' => 'new',
        		'created_at' => '2017-06-07 10:00:00',
        		'updated_at' => '2017-06-07 10:00:00'
        	],

        	[
        		'todolist_id' => 1,
        		'title' => 'tax product',
        		'description' => 'init tax product',
        		'status' => 'new',
        		'created_at' => '2017-06-07 12:15:00',
        		'updated_at' => '2017-06-07 12:15:00'
        	],

        	[
        		'todolist_id' => 1,
        		'title' => 'checkout product',
        		'description' => 'init checkout product',
        		'status' => 'new',
        		'created_at' => '2017-06-08 10:15:00',
        		'updated_at' => '2017-06-08 10:15:00'
        	],

        	[
        		'todolist_id' => 1,
        		'title' => 'shipping product',
        		'description' => 'init shipping product',
        		'status' => 'new',
        		'created_at' => '2017-06-08 15:15:00',
        		'updated_at' => '2017-06-08 15:15:00'
        	],

        	[
        		'todolist_id' => 2,
        		'title' => 'login user',
        		'description' => 'init login user',
        		'status' => 'new',
        		'created_at' => '2017-06-08 15:15:00',
        		'updated_at' => '2017-06-08 15:15:00'
        	],

        	[
        		'todolist_id' => 2,
        		'title' => 'register user',
        		'description' => 'init register user',
        		'status' => 'new',
        		'created_at' => '2017-06-08 16:15:00',
        		'updated_at' => '2017-06-08 16:15:00'
        	],

        	[
        		'todolist_id' => 2,
        		'title' => 'send email after register',
        		'description' => 'send active link to user email',
        		'status' => 'new',
        		'created_at' => '2017-06-10 10:15:00',
        		'updated_at' => '2017-06-10 10:15:00'
        	],

        	[
        		'todolist_id' => 5,
        		'title' => 'designe auth login view',
        		'description' => 'designe auth login view with VUE component',
        		'status' => 'new',
        		'created_at' => '2017-06-11 13:15:00',
        		'updated_at' => '2017-06-11 13:15:00'
        	],

        	[
        		'todolist_id' => 5,
        		'title' => 'designe auth register view',
        		'description' => 'designe auth register view with VUE component',
        		'status' => 'new',
        		'created_at' => '2017-06-11 13:30:00',
        		'updated_at' => '2017-06-11 13:30:00'
        	],

        	
        ];

        DB::table('tasks')->insert($tasks);
    }
}
