<?php

namespace App\Console\Commands;

use App\Task;
use App\Todolist;
use Illuminate\Console\Command;

class CheckTaskFailed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checktaskfailed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check task failed and update status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Task $task,Todolist $todolist)
    {
        parent::__construct();

        $this->task     = $task;
        $this->todolist = $todolist;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info( 'Checking...' );
        \DB::beginTransaction();
        try {
            
            $this->todolist->leftJoin('tasks',function($join){
                $join->on('todolists.id', '=', 'tasks.todolist_id');
                
            })
            ->where('tasks.status','<>',"failed")
            ->whereRaw('`tasks`.`due_date` < NOW()')
            ->update(['tasks.status'=>"failed",'todolists.status'=>"failed"]);
        
        } catch (\Exception $e) {
             \DB::rollback();
             $this->error( 'error...' );
             throw $e;
        }

        \DB::commit();

        $this->info( 'Finish!' );
    }
}
