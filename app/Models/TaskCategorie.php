<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskCategorie extends Model
{
    use HasFactory;
    protected $fillable = [
        "name", 
        "description",
        "user_id"
    ];
    
    protected $table = 'task_categorie';
}
