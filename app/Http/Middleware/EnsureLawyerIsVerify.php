<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureLawyerIsVerify
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
                return redirect()->route('lawyer.login');
                
            } elseif(Auth::user()->expired_at < now())
            {
                Auth::logout();
                 toastr()->error('حسابك منتهي الصلاحية يرجى التواصل مع فريق الدعم');
                return redirect()->route('lawyer.login');
            }
        }
        return $next($request);
    }
}
