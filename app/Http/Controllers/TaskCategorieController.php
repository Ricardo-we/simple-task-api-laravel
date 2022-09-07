<?php

namespace App\Http\Controllers;

use App\Base\BaseController as CustomBaseController;
use App\Models\TaskCategorie;
use Illuminate\Http\Request;
use App\Utils\ResponseFormatter;

class TaskCategorieController extends CustomBaseController
{
    private $entity_name = "Task Categorie";

    public function index()
    {   
        $task_categories = TaskCategorie::where("user_id", $this->user->id)->get();
        return $task_categories;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data["user_id"] = $this->user->id;
        $task_categorie = TaskCategorie::create($data);
        return $task_categorie;
    }

    public function show($id)
    {
        $task_categorie = TaskCategorie::where(["id" => $id, "user_id" => $this->user->id])->first();
        if(!isset($task_categorie)){
            return ResponseFormatter::formattedErrorResponse($this->entity_name, 404);
        }
        return $task_categorie;
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $task_categorie = TaskCategorie::where(["id" => $id, "user_id" => $this->user->id])->first();        
        unset($data["user_id"]);

        if(!isset($task_categorie)){
            return ResponseFormatter::formattedErrorResponse($this->entity_name, 404);
        }

        $task_categorie->update($data);
        return $task_categorie;
    }

    public function destroy($id)
    {
        $task_categorie = TaskCategorie::where(["id" => $id, "user_id" => $this->user->id])->first();
        if(!isset($subtask)){
            return ResponseFormatter::formattedErrorResponse($this->entity_name, 404);
        }
        
        $task_categorie->delete();
        return ResponseFormatter::defaultSuccess();
    }
}
