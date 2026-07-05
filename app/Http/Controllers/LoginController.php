<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store(LoginRequest $request)
    {
        if (Auth::attempt($request->validated(), $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $user->update(['last_login_at' => now()]);

            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Login',
                'description' => 'User logged in.',
            ]);

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    public function profile()
    {
        $logs = ActivityLog::where('user_id', auth()->id())
            ->latest()
            ->limit(20)
            ->get();

        $phpVersion = phpversion();
        $laravelVersion = app()->version();
        $dbConnection = config('database.default');

        return view('profile', compact('logs', 'phpVersion', 'laravelVersion', 'dbConnection'));
    }

    public function destroy(Request $request)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Logout',
            'description' => 'User logged out.',
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
