<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->guard('api')->user()->type  == 'admin') {
          return $next($request);
        }
        return new JsonResponse('ERROR!', 403);
    }
}
