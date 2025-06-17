<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            Log::info('AdminMiddleware: Starting middleware check', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user' => Auth::user(),
                'is_authenticated' => Auth::check(),
                'role' => Auth::check() ? Auth::user()->role : null,
                'session' => session()->all()
            ]);

            if (!Auth::check()) {
                Log::info('AdminMiddleware: User not authenticated, redirecting to login');
                return redirect()->route('login');
            }

            $user = Auth::user();
            Log::info('AdminMiddleware: User details', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]);

            if ($user->role !== 'admin') {
                Log::info('AdminMiddleware: User is not admin, redirecting to home');
                return redirect()->route('home')->with('error', 'Unauthorized access.');
            }

            Log::info('AdminMiddleware: User is admin, proceeding to next middleware');
            return $next($request);
        } catch (\Exception $e) {
            Log::error('AdminMiddleware: Error occurred', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('home')->with('error', 'An error occurred. Please try again.');
        }
    }
}
