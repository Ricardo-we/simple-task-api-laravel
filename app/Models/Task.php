<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task';
    protected $fillable = [
        "title",
        "description",
        "task_categorie_id",
        "user_id"
    ];

    public function sub_task(){
        return $this->hasMany(SubTask::class);
    }

}
