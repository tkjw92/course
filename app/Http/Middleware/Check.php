<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Check
{
    public function handle(Request $request, Closure $next, $role = 'student')
    {
        if ($role == 'islogin') {
            if (session()->has('account')) {
                return redirect('/student');
            } else {
                return $next($request);
            }
        }

        if (session()->has('account')) {
            if ($role == 'admin') {
                if (collect(session('account'))->get('role') == 'admin') {
                    return $next($request);
                } else {
                    return redirect('/student');
                }
            }
            return $next($request);
        }

        return redirect('/');
    }
}
