<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\SubTask;
use App\Models\TaskCategorie;

use App\Utils\ResponseFormatter;
use App\Base\BaseController as CustomBaseController;
use Illuminate\Support\Facades\DB;

class TaskController extends CustomBaseController 
{
    public $entity_name = "Task";

    public function userIsCategorieOwner($categorie_id)
    {
        $task_categorie = TaskCategorie::where(["id" => $categorie_id, "user_id" => $this->user->id])->first();
        return isset($task_categorie);
    }

    public function index()
    {
        $tasks = TaskCategorie::with("task")
            ->where("user_id",$this->user->id)
            ->orderByRaw("id ASC")
            ->get();
        $null_tasks = Task::where(["user_id" => $this->user->id, "task_categorie_id" => null])->get();

        foreach($tasks as $task_categorie){
            foreach($task_categorie->task as $task){
                $task["subtask_count"] = SubTask::where("task_id", $task->id)->count();
            }
        }
        foreach($null_tasks as $task){
            $task["subtask_count"] = SubTask::where("task_id", $task->id)->count();
        }
        
        $tasks->push(["task" => $null_tasks]);
        return $tasks;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data["user_id"] = $this->user->id;
        if(!$this->userIsCategorieOwner($data["task_categorie_id"])){
            $data["task_categorie_id"] = null;
        }
        $new_task = Task::create($data);
        return $new_task; 
    }

    public function show($id)
    {
        $subtasks = SubTask::where(["user_id"=> $this->user->id, "task_id"=> $id])->get();
        return $subtasks;
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $updated_task = Task::where(["id" => $id, "user_id" => $this->user->id])->first();
        
        unset($data["user_id"]);
        
        if(!isset($updated_task)){
            return ResponseFormatter::errorResponse("Task does not belong to current user", 404);
        }
        if(!$this->userIsCategorieOwner($data["task_categorie_id"])){
            $data["task_categorie_id"] = null;
        } 

        $updated_task->update($data);
        return $updated_task; 
        
    }

    public function destroy($id)
    {
        $task = Task::where(["id" => $id, "user_id" => $this->user->id])->first();
        
        if(!isset($task)) return ResponseFormatter::formattedErrorResponse($this->entity_name, 404);

        $task->delete();
        return ResponseFormatter::defaultSuccess();
    }
}
