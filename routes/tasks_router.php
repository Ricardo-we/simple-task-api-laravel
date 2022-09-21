<?php

use App\Http\Controllers\SubTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TaskCategorieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    return $request->user();
});

Route::post("users/register", [UsersController::class, "store"]);
Route::post("users/login", [UsersController::class, "login"]);

// Route::middleware("auth:sanctum")->get("tasks/{task_id}", [TaskController::class, "get_task_subtasks"]);
Route::middleware("auth:sanctum")->apiResource("tasks", TaskController::class);
Route::middleware("auth:sanctum")->apiResource("subtasks", SubTaskController::class);
Route::middleware("auth:sanctum")->apiResource("task-categories", TaskCategorieController::class);