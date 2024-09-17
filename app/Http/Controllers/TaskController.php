<?php
namespace App\Http\Controllers;
// namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\policies\TaskPolicy;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Controller class for managing tasks.
 *
 * This controller provides methods for interacting with tasks, including
 * creating, updating, deleting, and retrieving tasks. It also includes
 * methods for filtering tasks and adding comments to tasks.
 */
class TaskController extends Controller
{
    use AuthorizesRequests;
    
    protected $taskService;
    
    
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    
    
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $this->authorize('view', Task::class);
        $tasks = Task::with('project.users')->get();
        return response()->json($tasks);
    }
    
    
    public function filter(Request $request){
        $status = $request->input('status');
        $priority = $request->input('priority');
        $tasks = Task::whereRelation('project', function ($query) use ($status, $priority) {
                if ($status) {
                    $query->where('status', $status);
                }
                if ($priority) {
                    $query->where('priority', $priority);
                }
            })
            ->get();
        return response()->json($tasks);
        }
    
    /**
     * Creates a new task.
     *
     * @param \App\Http\Requests\StoreTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        $project = Project::findOrFail($request->input('project_id'));

        $this->authorize('create', [Task::class, $project]);

        $data = $request->validated();
        $task = $this->taskService->createTask($data);
        return response()->json($task, 201);
    }

    /**
     * Retrieves a task by its ID.
     *
     * @param int $id The ID of the task to retrieve.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $task=Task::findOrFail($id);
        $project = $task->load('project.users');
        return response()->json($project);
    }

    /**
     * Updates an existing task.
     *
     * @param \App\Http\Requests\UpdateTaskRequest $request
     * @param int $id The ID of the task to update.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, $id)   
    {
        // $this->authorize('update', $task);
        $task = Task::findOrFail($id);
     
            $data = $request->validated();
            $task = $this->taskService->updateTask($id, $data);
            return response()->json($task, 200);
       
    }


    /**
     * Updates the status of a task.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The ID of the task to update the status for.
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
       
            $status = $request->input('status');
            $task = $this->taskService->updateStatus($id, $status);
            return response()->json($task);
       
    }

    /**
     * Adds a comment to a task.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The ID of the task to add the comment to.
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment(Request $request, $id)
    {
        
            // $comment = $request->input('commint');
            $task = $this->taskService->addComment($id, $request->input('comment'));
            return response()->json(['message' => 'Comment added successfully'], 200);
      
    }

    /**
    
     * @param int $id The ID of the task to delete.
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    public function destroy($id)
    {
            $message = $this->taskService->deleteTask($id);
            return response()->json($message, 200);
    }


    
} 



