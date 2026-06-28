<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DailyWelcome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return $next($request);
            }

            $today = now()->toDateString();

            if (Session::get('welcomed_date') !== $today) {
                // Check if notification exists today in DB (in case of multiple devices/sessions)
                $alreadyWelcomed = $user->notifications()
                    ->where('type', \App\Notifications\DailyWelcomeNotification::class)
                    ->whereDate('created_at', $today)
                    ->exists();
                    
                if (!$alreadyWelcomed) {
                    $user->notify(new \App\Notifications\DailyWelcomeNotification());
                }
                
                Session::put('welcomed_date', $today);
            }
        }

        return $next($request);
    }
}
