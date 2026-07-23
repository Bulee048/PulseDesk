<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Organization;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];
        
        // If it's a known non-tenant subdomain or no subdomain (e.g. testing with direct IP/localhost without subdomain)
        if (in_array($subdomain, ['admin', 'localhost', 'pulsedesk', 'www', '127'])) {
            return $next($request);
        }

        // Check if there is a route parameter 'tenant' to override (for testing)
        if ($request->route('tenant')) {
            $subdomain = $request->route('tenant');
        }

        $organization = Organization::where('slug', $subdomain)->firstOrFail();

        if ($organization->status === 'suspended') {
            return response()->view('errors.suspended', ['organization' => $organization], 403);
        }

        app()->instance(Organization::class, $organization);
        \Illuminate\Support\Facades\URL::defaults(['tenant' => $subdomain]);

        return $next($request);
    }
}
