<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
        protected $fillable = [
        'name',
        'description',
    
    ];
        public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role', 'contribution_hours', 'last_activity');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function oldestTask(){
        return $this->hasOne(Task::class)->oldestOfMany();
    }
    public function latestTask(){
        return $this->hasOne(Task::class)->latestOfMany();
    }

    public function maxPriorityTask()
    {
        $priority=[
            1=>'low',
            2=>'medium',
            3=>'high',
        ];
        return $this->hasOne(Task::class)->ofMany('priority', 'min')->where('title', 'like', '%min%');;

    }
}