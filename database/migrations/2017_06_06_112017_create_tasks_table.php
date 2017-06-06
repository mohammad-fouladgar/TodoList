<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('todolist_id')->unsigned();
            $table->string('title');
            $table->string('description');
            $table->timestamp('due_date')->nullable();
            $table->enum('status',['new','done','cancelled','failed','extended']);

            $table->foreign('todolist_id','todolist_id')
                  ->references('id')
                  ->on('todolists')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
