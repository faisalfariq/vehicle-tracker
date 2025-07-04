<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApproverMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        
        // Allow admin and approver roles
        if ($user->role->name === 'admin' || $user->role->name === 'approver') {
            return $next($request);
        }

        // Redirect regular users with error message
        return redirect()->back()->with('error', 'Access denied. Only administrators and approvers can access this feature.');
    }
} 