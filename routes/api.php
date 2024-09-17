<?php 
  
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\ProjectController;
  
Route::group([ 
    'middleware' => 'api', 
    'prefix' => 'auth' 
], function ($router) { 
    Route::post('/register', [AuthController::class, 'register'])->name('register'); 
    Route::post('/login', [AuthController::class, 'login'])->name('login'); 
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout'); 
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh'); 
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me'); 
}); 

// =======================================================USER==============================================
Route::middleware(['admin'])->group(function () {
    Route::apiResource('/users', UserController::class);
});

    // =======================================================PROJECT==============================================
Route::middleware(['admin'])->group(function () {
    Route::apiResource('/projects', ProjectController::class);
});
Route::get('/projects/{project}/latestTask', [ProjectController::class, 'latestTask']);
Route::get('/projects/{project}/oldestTask', [ProjectController::class, 'oldestTask']);
Route::get('/projects/{project}/maxPriorityTask', [ProjectController::class, 'maxPriorityTask']);
// =======================================================TASK==============================================
Route::apiResource('/tasks', TaskController::class);
Route::put('/tasks/{task}/updateStatus', [TaskController::class, 'updateStatus']);      
Route::post('/tasks/{task}/addComment', [TaskController::class, 'addComment']);
Route::get('/tasks/filter', [TaskController::class, 'filter']);


