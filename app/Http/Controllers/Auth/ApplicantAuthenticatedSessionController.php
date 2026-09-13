<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ApplicantAuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.applicant.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->applicant_authenticate();

        $request->session()->regenerate();

        if ($request->filled('redirect')) {
            $target = (string) $request->input('redirect');
            $isRelative = ! Str::startsWith($target, ['//', 'http://', 'https://']);
            $isLocal = $isRelative && ! Str::contains($target, ["\r", "\n"]);
            if ($isLocal) {
                return redirect('/'.ltrim($target, '/'));
            }
        }
        return redirect()->route('applicant.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('applicant')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
