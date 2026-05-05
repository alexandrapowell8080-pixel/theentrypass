<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->session()->get('user_id');
        $role = $request->session()->get('role');

        if (! $user || $role !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
            }

            return redirect('/')->with('error', 'Admin access required.');
        }

        return $next($request);
    }
}
