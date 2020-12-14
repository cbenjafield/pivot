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

        $website = Site::where('tld', $domain)->firstOrFail();

        if(! in_array($request->ip(), ['192.168.10.10', '192.168.10.1'])) {
            if(! $request->secure() && $website->uses_https) {
                return redirect()->secure($request->getRequestUri());
            }

            $start = substr($request->getHost(), 0, 3);

            if($start != 'www' && $website->uses_www) {
                return redirect()->to($website->domain() . $request->getRequestUri());
            }
        }

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
