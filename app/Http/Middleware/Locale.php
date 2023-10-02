<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Auth;
use DB;

class Locale
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
       if(!empty(Auth::user()->id))
        {
            $lan = DB::table('users')->where('id', Auth::user()->id)->first();
            if(!empty($lan))
            {
                $locale = $lan->language;
            }
            else
            {
                $locale = 'en';
            }
           App::setLocale($locale);
        }
       return $next($request);
    }
}
