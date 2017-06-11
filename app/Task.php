<?php

namespace App;

use App\Foundation\DataViewer;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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

    public $timestamps = false;

    /**
     * Get the todolist that owns the task.
     */
    public function todolist()
    {
        return $this->belongsTo('App\Todolist');
    }

    public function getDueDateAttribute($date)
    {
        $end    = Carbon::parse($date);
        $now    = Carbon::now();
        $length = $now->diffInDays($end,false);

        if ($length <= 0) {
            return 'expired';
        }
        elseif ($length < 7 ) {
            return $length.' remaining Days';
        }
        
        
        return Carbon::parse($date)->format('Y-m-d');
    }
}
