<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TesterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $projectId = $request->project_id;

    if (auth()->check()) {
        $userRole = auth()->user()->projects()->where('project_id', $projectId)->first()?->pivot->role;

        if ($userRole === 'developer') {
            return $next($request);
        }
    }
    return response()->json(['error' => 'Unauthorized.'], 403);
    }
}
