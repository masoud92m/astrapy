<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MinifyHtmlOutput
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $contentType = $response->headers->get('Content-Type');

        if ($contentType && str_starts_with($contentType, 'text/html')) {
            $content = $response->getContent();

            if ($content) {
                $content = $this->minify($content);
                $response->setContent($content);
            }
        }

        return $response;
    }

    protected function minify(string $html): string
    {
        $html = preg_replace('/<!--(?!\[if).*?-->/', '', $html);
        $html = preg_replace([
            '/^\s+/m',
            '/\s+$/m',
        ], '', $html);

        return preg_replace('/\h{2,}/', ' ', $html);
    }
}
