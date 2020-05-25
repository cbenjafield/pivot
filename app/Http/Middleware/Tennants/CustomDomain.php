<?php

namespace App\Http\Middleware\Tennants;

use App\Site;
use Closure;

class CustomDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $domain = $request->getHost();
        $website = Site::where('tld', $domain)->firstOrFail();

        // Append the domain and site to the request object
        // for easy retrieval in the application
        // later on down the line.
        $request->merge([
            'domain' => $domain,
            'website' => $website,
        ]);

        return $next($request);
    }
}
