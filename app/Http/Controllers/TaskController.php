<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

use App\Utils\ResponseFormatter;
use App\Base\BaseController as CustomBaseController;
use App\Models\SubTask;
use App\Models\TaskCategorie;

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
        $tasks = Task::where("user_id", $this->user->id)->orderByRaw("task_categorie_id ASC")->get();
        foreach($tasks as $task){
            $task["subtask_count"] = SubTask::where("task_id", $task->id)->count();
        }
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
