<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IsUserBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->banned_till != null) {
            $isPermanent = (int) $user->banned_till === 0 || (string) $user->banned_till === '0';
            $stillBanned = $isPermanent || now()->lessThan($user->banned_till);

            if ($stillBanned) {
                if ($isPermanent) {
                    $message = 'Your account has been banned permanently.';
                } else {
                    $banned_days = now()->diffInDays($user->banned_till) + 1;
                    $message = 'Your account has been suspended for ' . $banned_days . ' ' . Str::plural('day', $banned_days);
                }

                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json(['status' => false, 'message' => $message], 403);
                }

                return redirect()->route('login')->with('message', $message);
            }
        }

        return $next($request);
    }
}
