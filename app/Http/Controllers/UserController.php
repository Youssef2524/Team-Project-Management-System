<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }    public function index()
    {
     $user=User::with('projects.tasks')->get();
     return response()->json($user);
    }

    public function show($id)
    {
        $user=User::findOrFail($id);
        $project = $user->load('projects.tasks');
        return response()->json($user);
    }
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());
        return response()->json($user);
    }
    public function update(UpdateUserRequest  $request, User $user)
    {
        $user = $this->userService->updateUser($user, $request->validated());
        return response()->json($user);

    }
    public function destroy(User $user)
    {

        $user->delete();
        return response()->json(null, 204);
    }
}
