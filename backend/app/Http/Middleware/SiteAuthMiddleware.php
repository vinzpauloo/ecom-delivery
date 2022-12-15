<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;


class SiteAuthMiddleware
{
    use HttpResponses;

    private $key;

    public function __construct()
    {
        $this->key = config('hashing.secret_key');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $headerAuthorization = $request->header('X-Authorization');

        if($headerAuthorization === $this->calculateHash($request)){
            return $next($request);
        }else{

            //change after successful internal integration
            return $this->error($request->header('X-Authorization'),401,':P');
        }
        
    }

    private function calculateHash($request)
    {
        $code = '==';
        $code .= $request->path();
        $code .= '?';
        $code .= http_build_query($request->all());
        $code .= '&';
        $code .= $this->key;    
        return md5(md5($code));
    }
}
