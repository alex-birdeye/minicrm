<?php
namespace App\Http\Middleware;
use Closure;
use App;
class Localization
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
        if ($request->header('locale')) {
            App::setLocale($request->header('locale'));
        }
//        dd($request->header('locale'));
        return $next($request);
    }
}