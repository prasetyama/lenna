<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LogEntry;

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

    public function terminate(Request $request, Response $response)
    {
        $logEntry = new LogEntry();

        $logEntry->url = $request->getUri();
        $logEntry->method = $request->getMethod();
        $logEntry->body = json_decode($request->getContent(), true);
        $logEntry->header = $request->getHeader();
        $logEntry->ip = $request->getIp();
        $logEntry->response_code = $response->getStatusCode();

        $logEntry->save();
    }
}
