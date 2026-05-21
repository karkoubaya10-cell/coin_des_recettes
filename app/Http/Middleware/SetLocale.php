<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Apply the language saved in session to every web request.
        if(session()->has('locale')){//si session a local sinon continue avec langue par défaut
            App::setLocale(session('locale'));//modifier local par langue choisie
        }

        return $next($request);//continue execution de request
    }
}
