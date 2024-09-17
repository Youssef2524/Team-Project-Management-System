<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
      'title', 'description', 'status', 'priority', 'due_date', 'project_id', 'start_task', 'finsh_task', 'commint'
    ];


    public function project()
{
    return $this->belongsTo(Project::class);
}
public function users()
{
    return $this->belongsTo(User::class);
}
}