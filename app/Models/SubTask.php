<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;
    protected $table = 'sub_task';
    protected $fillable = [
        "title",
        "description",
        "task_id",
        "user_id",
        "end_date"
    ];
}
