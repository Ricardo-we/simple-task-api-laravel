<?php

namespace App\Http\Controllers;

use App\Base\BaseController as CustomBaseController;
use Illuminate\Http\Request;

use App\Models\SubTask;
use App\Utils\ResponseFormatter;

class SubTaskController extends CustomBaseController 
{
    private $entity_name = "Subtask";

    public function index()
    {
        $subtasks = SubTask::where("user_id", $this->user->id)->get();
        return $subtasks;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data["user_id"] = $this->user->id;
        $subtask = SubTask::create($data);        
        return $subtask;
    }

    public function show($id)
    {
        $subtask = SubTask::where(["id" => $id, "user_id" => $this->user->id])->first();
        if(!isset($subtask)){
            return ResponseFormatter::formattedErrorResponse($this->entity_name, 404);
        }
        return $subtask;
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $subtask = SubTask::where(["id" => $id, "user_id" => $this->user->id])->first();        
        unset($data["user_id"]);

        if(!isset($subtask)){
            return ResponseFormatter::formattedErrorResponse($this->entity_name, 404);
        }

        $subtask->update($data);
        return $subtask;
    }
 
    public function destroy($id)
    {
        $subtask = SubTask::where(["id" => $id, "user_id" => $this->user->id])->first();
        if(isset($subtask)){
            $subtask->delete();
            return ResponseFormatter::defaultSuccess();
        }
        
        return ResponseFormatter::formattedErrorResponse($this->entity_name, 404);
    }
}
