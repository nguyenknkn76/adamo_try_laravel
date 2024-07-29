<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $logData = [
            $request->method(),
            $request->getPathInfo(),
            $request->all()
        ];

        $response = $next($request);

        $logData['response_data'] = $response instanceof Response ? $response->getContent() : 'No response data';

        // Log::info('HTTP Request:', $logData);

        return $response;
    }
}




