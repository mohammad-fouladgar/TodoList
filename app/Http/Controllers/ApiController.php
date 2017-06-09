<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * [tasks description]
     * @param  [type] $todolist [description]
     * @return [type]           [description]
     */
    public function tasks($todolist)
    {
        $todolist = auth()
                  ->user()
                  ->todolists()
                  ->with(['tasks'=>function($q){
                    $q->select('*');
                  }])
                  ->whereId($todolist)
                  ->first();
        return view('tasks',compact('todolist'));
    }
    
    /**
     * [updateTaskStatus description]
     * @param  Request $request    [description]
     * @param  [type]  $todolistId [description]
     * @param  [type]  $taskId     [description]
     * @return [type]              [description]
     */
    public function updateTaskStatus(Request $request,$todolistId,$taskId)
    {

        // return $request->toArray();
        $todolist = auth()->user()->todolists()
        // ->with(['tasks'=>function($q) use($taskId){
        //     $q->whereId($taskId);
        // }])
        ->whereId($todolistId)->firstOrFail(['id']);

         \DB::beginTransaction();
        try {
            
            // update task status
            Task::whereId($taskId)->whereTodolistId($todolist->id)->update(['status'=>$request->status]);
            
            // can call listener on update task
            // but time loss.
            if ($request->status == 'done' and $todolist->status !== 'done')
            {
                // update todo list status if task done
                $todolist->status = 'done';
                $todolist->update();
            }
        } catch (\Exception $e) {
             \DB::rollback(); 
             throw $e;
        }
        \DB::commit();

        return response()->json(['status'=>true]);
    }

    /**
     * [deleteTask description]
     * @param  [type] $todolistId [description]
     * @param  [type] $taskId     [description]
     * @return [type]             [description]
     */
    public function deleteTask($todolistId,$taskId)
    {

        $todolist = auth()->user()->todolists()
        // ->with(['tasks'=>function($q) use($taskId){
        //     $q->whereId($taskId);
        // }])
        ->whereId($todolistId)->firstOrFail(['id']);

         \DB::beginTransaction();
        try {
            
            // delete task
            Task::whereId($taskId)->whereTodolistId($todolist->id)->delete();
        } catch (\Exception $e) {
             \DB::rollback(); 
             throw $e;
        }
        \DB::commit();

        return response()->json(['status'=>true]);
    }

    /**
     * [deleteTodolist description]
     * @param  [type] $todolistId [description]
     * @return [type]             [description]
     */
    public function deleteTodolist($todolistId)
    {
        $todolist = auth()->user()->todolists()
        ->with(['tasks'=>function($q){
            #code...
        }])
        ->whereId($todolistId)->firstOrFail(['id']);

        if (! $todolist->tasks->count()) {
           
           return response()->json(['status'=>$todolist->delete()]);
        }

        return response()->json(['errorMessage'=>'Can\'t delete.this item has tasks'],422);
    }

    /**
     * [canceleTodolist description]
     * @param  [type] $todolistId [description]
     * @return [type]             [description]
     */
    public function canceleTodolist($todolistId)
    {

        $todolist = auth()
                        ->user()
                        ->todolists()
                        ->whereId($todolistId)
                        ->firstOrFail(['id']);

         \DB::beginTransaction();
        try {
            
                $todolist->update(['status'=>'cancelled']);
                
                // all task status update to cancelled
                Task::whereTodolistId($todolist->id)->update(['status'=>'cancelled']);

        } catch (\Exception $e) {
             \DB::rollback(); 
             throw $e;
        }
        \DB::commit();

        return response()->json(['status'=>true]);
    }

}
