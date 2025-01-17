<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // XSS Protection Headers
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Content Security Policy (CSP)
        $response->headers->set('Content-Security-Policy', "
            default-src 'self';
            script-src 'self' https://cdnjs.cloudflare.com 'unsafe-inline' 'unsafe-eval';
            style-src 'self' https://cdnjs.cloudflare.com 'unsafe-inline';
            img-src 'self' data:;
            font-src 'self';
            frame-ancestors 'none';
            form-action 'self';
        ");
        
        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');
        
        // Force HTTPS
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        
        // Control referrer information
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}