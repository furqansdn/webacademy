<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
// use App\Models\Course\Lesson;

class Subscription
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
        $route = '';

        if ($request->route('lesson') != null) {
            $route = $request->route('lesson')->isPremium;
        } elseif ($request->route('quiz') != null) {
            $route = $request->route('quiz')->is_premium;
        }

        if ($route == 1) {
            if (!Auth::user()->isSubscribed()) {
                return redirect()->route('client::subscription.plan');
            }
        }
        return $next($request);
    }
}
