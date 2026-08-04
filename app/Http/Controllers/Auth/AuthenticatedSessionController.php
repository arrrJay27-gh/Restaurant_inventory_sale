<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // 1. Linisin ang role string (tinatanggal ang spaces at underscores, ginagawang lowercase)
        $cleanRole = strtolower(str_replace([' ', '_'], '', $user->role ?? ''));

        // 2. Mga allowed roles para sa Admin / Staff Dashboard
        $allowedDashboardRoles = ['admin', 'staff', 'manager', 'inventorymanager'];

        // 3. Kung Admin / Staff / Inventory Manager, i-redirect sa Dashboard (o sa intended page nila)
        if (in_array($cleanRole, $allowedDashboardRoles)) {
            return redirect()->intended('/dashboard');
        }

        // 4. Lahat ng Customer / Regular Users ay didiretso sa POS ordering
        return redirect()->intended('/pos');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}