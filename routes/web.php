<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){
	return redirect()->route('dashboard');
});

Route::group(['middleware'=>'auth'],function(){
	
	Route::get('/todos/{id}/tasks',function($id){
		$model = auth()
				  ->user()
				  ->todolists()
				  ->with(['tasks'=>function($q){
				  	$q->select('*')->searchPaginateAndOrder();
				  }])
				  ->whereId($id)
				  ->first();
	
		$columns = App\Task::$columns;

	    return response()
	            ->json([
	                'model' => $model,
	                'columns' => $columns,
	                'statuses'=>App\Task::$statuses
	            ]);

	})->name('tasks');

	Route::get('/todolists',function(){
		$model   = auth()
		                ->user()
		                ->todolists()
		                ->searchPaginateAndOrder()->get(['id', 'title', 'description','status', 'created_at']);
		
		$columns = App\Todolist::$columns;

	    return response()
	            ->json([
	                'model' => $model,
	                'columns' => $columns,
	                'statuses'=>App\Todolist::$statuses
	            ]);
	})->name('user.todolists');
});


Auth::routes();

Route::get('/dashboard', 'ApiController@index')->name('dashboard');
Route::get('/todolists/{id}', 'ApiController@tasks');
Route::patch('/todolists/{id}/task/{taskid}','ApiController@updateTaskStatus');
Route::delete('/todolists/{id}/task/{taskid}','ApiController@deleteTask');
Route::delete('/todolists/{id}','ApiController@deleteTodolist');
Route::patch('/todolists/{id}/cancel','ApiController@canceleTodolist');
Route::get('/task/{taskid}/due/{day}','ApiController@updateTaskDueDate');

Route::get('register/confirm/{token}','Auth\RegisterController@confirmEmail')->name('auth.confirm.email');
