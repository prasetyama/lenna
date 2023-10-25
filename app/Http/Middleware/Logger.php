<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LogEntry;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class Logger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $logEntry = new LogEntry();

        $logEntry->url = $request->getUri();
        $logEntry->method = $request->getMethod();
        $logEntry->body = json_encode($request->getContent(), true);
        $logEntry->header = json_encode($request->header(), true);
        $logEntry->ip = $request->ip();
        $logEntry->response_code = $response->getStatusCode();

        $logEntry->save();
    }
}
