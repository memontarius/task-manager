<?php

namespace App\Http\Middleware;

use App\Services\VisitorCounter;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class OnlineVisitorTracker
{
    public function __construct(
        private readonly VisitorCounter $visitorCounter
    )
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->visitorCounter->handleEntrance($request->ip());
        return $next($request);
    }
}
