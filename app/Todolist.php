<?php
namespace App;

use App\Foundation\DataViewer;
use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{

    use DataViewer;

    /**
     * [$columns description]
     * @var [type]
     */
     public static $columns = [
        'id','user_id', 'title', 'description','status', 'created_at', 'updated_at'
    ];

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
