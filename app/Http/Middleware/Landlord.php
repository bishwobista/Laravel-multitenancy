<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
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
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!str_contains(url()->current(), '/global.org')){
            throw new Exception("sorry");
        }
        return $next($request);
    }

}

