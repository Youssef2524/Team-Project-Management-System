<?php
namespace App\Services;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskService
{
    use AuthorizesRequests;

/*
    @param  $data
    @return $createTask
  */
    public function createTask($data)
    {
        try{


            return Task::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
                'priority' => $data['priority'],
                'project_id' => $data['project_id'],
                'due_date' => $data['due_date'],
                'start_task' => Carbon::now(),
            ]);


        }
     catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Task not found'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Unable to create task', 'message' => $e->getMessage()], 500);
    }
    }

    /*
    @param  $data
    @return $updateTask

    */
    public function updateTask($data, $task)
    {
        try {
            $this->authorize('update', $task);

        $task->update([
            'title' => $data['title'] ?? $task->title,
            'description' => $data['description'] ?? $task->description,
            'status' => $data['status'] ?? $task->status,
            'priority' => $data['priority'] ?? $task->priority,
            'due_date' => $data['due_date'] ?? $task->due_date,
            'project_id' => $data['project_id'] ?? $task->project_id,
        ]);
        return $task;
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Task not found'], 404);
    }
        }

        /*
        @param  $data
        @return $updateTask
        */
          public function updateStatus($id, $task)
    {
        try {
            $this->authorize('updateStatus', $task);

        $task = Task::findOrFail($id);
        $task->status = $status;
        $task->save();
        return $task;
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Task not found'], 404);
    }
    }
    /*
    @param  $data
    @return $addComment
    */
    public function addComment($id, $comment)
    {
        try {
            
            $task = Task::find($id);


        $this->authorize('addComment', $task);

        // إضافة التعليق
        $task->commint = $comment;
        $task->save();

        return $task;
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Task not found'], 404);
    }
    }

    /*  
    @param  $data
    @return $deleteTask
    */
    public function deleteTask($id)
    {
        try {
            
            $task = Task::findOrFail($id);
            // $this->authorize('delete', Task::class);
            $this->authorize('delete', $task);

        $task->delete();
        return ['message' => 'Task deleted successfully'];
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Task not found'], 404);
    }
    }


}