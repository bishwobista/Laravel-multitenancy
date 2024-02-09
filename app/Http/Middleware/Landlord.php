<?php

namespace App\Http\Middleware;

use Closure;
use http\Exception;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Exceptions\NoCurrentTenant;
use Symfony\Component\HttpFoundation\Response;

class Landlord
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws NoCurrentTenant
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!str_contains(url()->current(), '/global.local')){
            throw NoCurrentTenant::landlord();
        }
        return $next($request);
    }

}

