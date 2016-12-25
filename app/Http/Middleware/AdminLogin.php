<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Pagination\Paginator;

class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session('user')) {
            return redirect('admin/login');
        }

        return $next($request);
    }
}
