<?php

namespace App;

use App\Foundation\DataViewer;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use DataViewer;

    /**
     * [$columns description]
     * @var [type]
     */
           public static $columns = [
        'id','todolist_id', 'title', 'description','due_date' ,'status', 'created_at','updated_at'
    ];

    /**
     * [$columns description]
     * @var [type]
     */
     public static $statuses = [
        'all','new','done','cancelled','failed','extended'
    ];

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
