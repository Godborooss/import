<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPackOwner
{
    public function handle(Request $request, Closure $next)
    {
        $pack = $request->route('pack');

        if ($pack && $pack->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
