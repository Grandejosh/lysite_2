<?php

namespace App\Http\Middleware;

use App\Events\InstructorOnline;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OnlineMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $users_to_offline = User::where('chat_last_activity', '<', now()->subMinutes(5));
        $users_to_online = User::where('chat_last_activity', '>=', now()->subMinutes(5));

        if (isset($users_to_offline)) {
            $users_to_offline->update(['is_online' => false]);
        }
        if (isset($users_to_online)) {
            $users_to_online->update(['is_online' => true]);
        }
        if (auth()->check()) {
            $cache_value = Cache::put('user-is-online', auth()->id(), \Carbon\Carbon::now()->addMinutes(1));
            $user = User::find(Cache::get('user-is-online'));
            $user->chat_last_activity = now()->addMinutes(5);
            $user->is_online = true;
            $user->save();
        } elseif (!auth()->check() and filled(Cache::get('user-is-online'))) {
            $user = User::find(Cache::get('user-is-online'));
            if (isset($user)) {
                $user->is_online = false;
                $user->save();
            }
        }
        return $next($request);
    }
}
