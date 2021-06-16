<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Carbon\Carbon;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */


    public function handle($request, Closure $next) {
        
        $authToken = $request->header('Authorization');

        if ($authToken) {
            $generatedToken = sha1(env('ENCRYPTOR_KEY').'#'.json_encode($request->post()));            
            if($generatedToken !== $authToken) {
                throw new \App\Exceptions\ApiExceptions('Invalid authentication.');
            }
        } else {
            throw new \App\Exceptions\ApiExceptions('Invalid authentication.');
        }

        $response =  $next($request);

        if ($response->exception) {
            return $response;
        }

        $content = json_decode($response->getContent(), true);
        $content['success'] = true;
        $content['timestamp'] = Carbon::now()->toDateTimeString();
        $response->setContent(json_encode($content));

        return $response;
    }

}
