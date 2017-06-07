<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'status',
    ];

    /**
     * Get the user that owns the todolist.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * Get the tasks for the todolist.
     */
    public function tasks()
    {
        return $this->hasMany('App\Todolist');
    }
}
