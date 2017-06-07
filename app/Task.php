<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'status','due_date'
    ];

    /**
     * Get the todolist that owns the task.
     */
    public function todolist()
    {
        return $this->belongsTo('App\Todolist');
    }
}
