<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function leave()
    {
        if (session()->has('impersonating')) {
            $superAdminId = session('impersonating');
            session()->forget('impersonating');
            
            Auth::loginUsingId($superAdminId);
            
            return redirect()->to('http://admin.' . preg_replace('#^https?://#', '', env('APP_URL', 'pulsedesk.test')) . '/admin');
        }

        return redirect('/');
    }
}
