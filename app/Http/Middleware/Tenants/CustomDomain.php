<?php

namespace App\Http\Middleware\Tenants;

use App\Site;
use Closure;
use Pdp\Parser;
use Utopia\Domains\Domain;

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
        $domain = $this->processDomain($request);

        dd($domain);

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

    /**
     * Pluck the domain from the requested host.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function processDomain($request)
    {
        $host = $request->getHost();
        
        $domain = new Domain($host);

        return $domain->getRegisterable();
    }
}
