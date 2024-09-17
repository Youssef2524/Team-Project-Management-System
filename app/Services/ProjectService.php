<?php

namespace App\Services;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectService
{
    /**
     * Retrieve all projects with their associated users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllProjects()
    {
        return Project::with('tasks')->get();
    }

    /**
     * Retrieve the latest task of a project.
     *
     * @param  int  $projectId
     * @return \App\Models\Task|null
     */
    public function getLatestTask($projectId)
    {
        try {
        $project = Project::findOrFail($projectId);
        return $project->latestTask;
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Project not found'], 404);
    }
    }

    /**
     * Retrieve the oldest task of a project.
     *
     * @param  int  $projectId
     * @return \App\Models\Task|null
     */
    public function getOldestTask($projectId)
    {
        try {
        $project = Project::findOrFail($projectId);
        return $project->oldestTask;
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Project not found'], 404);
    }
    }

    /**
     * Retrieve the task with the maximum priority for a project.
     *
     * @param  int  $projectId
     * @return \App\Models\Task|null
     */
    public function getMaxPriorityTask($projectId)
    {
        try {
        $project = Project::findOrFail($projectId);
        return $project->maxPriorityTask;
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Project not found'], 404);
    }
    }

    /**
     * Create a new project and assign users with their roles.
     *
     * @param  array  $data
     * @return \App\Models\Project
     */
    public function createProject(array $data)
    {
        try {
        $project = new Project();
        $project->name = $data['name'];
        $project->description = $data['description'];
        $project->save();

        $userIds = $data['user_id'];
        $roles = $data['role'];

        if (count($userIds) !== count($roles)) {
            throw new \Exception('The number of users must match the number of roles.');
        }

        foreach ($userIds as $index => $userId) {
            $user = User::findOrFail($userId);
            $project->users()->attach($user->id, [
                'role' => $roles[$index],
                'contribution_hours' => $data['contribution_hours'],
                'last_activity' => now()
            ]);
        }

        return $project;
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
    }

    /**
     * Retrieve a single project by its ID and load its users.
     *
     * @param  int  $projectId
     * @return \App\Models\Project
     */
    public function getProjectById($projectId)
    {
        try {
        $project = Project::findOrFail($projectId);
        return $project->load('users');
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Project not found'], 404);
    }
    }

    /**
     * Update an existing project and assign a user to the project.
     *
     * @param  int  $projectId
     * @param  array  $data
     * @return \App\Models\Project
     */
    public function updateProject($projectId, array $data)
    {
        try {
            $project = Project::findOrFail($projectId);
            $project->name = $data['name'];
        $project->description = $data['description'];
        $project->save();

        $userIds = $data['user_id'];
        $roles = $data['role'];
        if (count($userIds) !== count($roles)) {
            return response()->json(['error' => 'The number of users must match the number of roles.'], 400);
        }
        $syncData = [];
        foreach ($userIds as $index => $userId) {
            $syncData[$userId] = [
                'role' => $roles[$index],
                'contribution_hours' => 0,
                'last_activity' => now()
            ];
        }
        $project->users()->sync($syncData);
        return $project;
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Project or User not found'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
    }

    }

    /**
     * Delete a project by its ID.
     *
     * @param  int  $projectId
     * @return void
     */
    public function deleteProject($projectId)
    {
        try {
        $project = Project::findOrFail($projectId);
        $project->delete();
    } catch (ModelNotFoundException $e) {
        // إرجاع خطأ إذا لم يتم العثور على المشروع
        return response()->json(['error' => 'Project not found'], 404);
    } catch (\Exception $e) {
        // إرجاع رسالة خطأ إذا حدث أي خطأ آخر
        return response()->json(['error' => 'Unable to delete project', 'message' => $e->getMessage()], 500);
    }
    }
}
