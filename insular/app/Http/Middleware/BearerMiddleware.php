<?php

namespace App\Http\Middleware;

use App\BaseResponse;
use Closure;

class BearerMiddleware
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
        $header = $request->header('bearer');
        if($header == null || $header != 'value' ){
            $response = new BaseResponse();

            $response-> data= "[]";
            $response-> message = "Unauthorized request";
            $response ->status = "401";

            return response('{"message":"Invalid token", "data" : [] , "status" :401}', 401);
        }
        else{

            return $next($request);

        }

    }
}
