<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomerIsVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check())
        {
            if(Auth::user()->is_verified == false)
            {
                Auth::logout();
                toastr()->error('حسابك غير موثق. يرجى التحقق من رقم الهاتف أولاً.');
                return redirect()->route('customer.login');
                
            }
                // toastr()->warning('أنت مسجل دخول بالفعل.');
                // return redirect()->route('customer.dashboard');
        }
        return $next($request);
    }
}
