<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AuditLog;
use Illuminate\Support\Str;

class AuditLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log mutating requests
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            try {
                $user = $request->user();
                $routeName = optional($request->route())->getName();

                AuditLog::create([
                    'user_id' => $user?->id,
                    'action' => $this->guessActionFromMethod($request->method(), $routeName),
                    'model_type' => null,
                    'model_id' => null,
                    'route' => $routeName,
                    'method' => $request->method(),
                    'ip' => $request->ip(),
                    'user_agent' => substr((string) $request->userAgent(), 0, 500),
                    'data' => $this->sanitize($request->all()),
                ]);
            } catch (\Throwable $e) {
                // Do not block request on logging failure
            }
        }

        return $response;
    }

    protected function sanitize(array $data): array
    {
        foreach (['password', 'password_confirmation', 'current_password', 'MAIL_PASSWORD'] as $key) {
            if (array_key_exists($key, $data)) {
                $data[$key] = '***';
            }
        }
        return $data;
    }

    protected function guessActionFromMethod(string $method, ?string $routeName): string
    {
        $method = strtoupper($method);
        if ($method === 'POST') {
            return Str::contains((string) $routeName, ['update', 'edit']) ? 'update' : 'create';
        }
        if (in_array($method, ['PUT', 'PATCH'])) {
            return 'update';
        }
        if ($method === 'DELETE') {
            return 'delete';
        }
        return 'unknown';
    }
}
