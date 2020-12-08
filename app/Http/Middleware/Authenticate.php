<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->is('api/*')) {
            throw new HttpResponseException(response()->json(['status' => false, 'detail' => 'Unauthorized Request'], 401));
        } else {
            if (!$request->expectsJson()) {
                return route('login');
            }
        }
    }
}
