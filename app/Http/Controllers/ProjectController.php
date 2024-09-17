<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     *  Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = $this->projectService->getAllProjects();
        return response()->json($projects);
    }
    
    /**
   
     * @param  \Illuminate\Http\projectId  $request
     * @return \Illuminate\Http\Response
     */
    public function latestTask($projectId)
    {
        
            $latestTask = $this->projectService->getLatestTask($projectId);
            return response()->json($latestTask);
      
    }
  /**
     * @param  \Illuminate\Http\projectId  $request
     * @return \Illuminate\Http\Response
     */
    public function oldestTask($projectId)
    {
        
            $oldestTask = $this->projectService->getOldestTask($projectId);
            return response()->json($oldestTask);
      
    }
 /**
     * @param  \Illuminate\Http\projectId  $request
     * @return \Illuminate\Http\Response
     */
    public function maxPriorityTask($projectId)
    {
        
            $maxPriorityTask = $this->projectService->getMaxPriorityTask($projectId);
            return response()->json($maxPriorityTask);
      
    }
 /**
     * @param  \Illuminate\Http\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
     
            $project = $this->projectService->createProject($request->validated());
            return response()->json(['success' => true, 'Project' => $project]);
      
    }
/**
     * @param  \Illuminate\Http\id  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
            $project = $this->projectService->getProjectById($id);
            return response()->json($project);
       
    }
/**
     * @param  \Illuminate\Http\id  $id
     * @param  \Illuminate\Http\UpdateProjectRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        
            $project = $this->projectService->updateProject($id, $request->validated());
            if ($project) {
                return response()->json($project, 200);
            } else {
                return response()->json(['error' => 'Project not found'], 404);
            }
       
    }
    /**
     * @param  \Illuminate\Http\id  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
                $this->projectService->deleteProject($id);
                return response()->json(null, 204);
    }
}
