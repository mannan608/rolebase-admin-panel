<?php

use Illuminate\Support\Facades\Route;

// ===== AUTHENTICATION ROUTES =====
Route::get('/login', function () {
    return session('user') ? redirect('/') : view('pages.auth.signin');
})->name('login');

Route::get('/register', function () {
    return view('pages.auth.signup');
})->name('register');

// Login submit - process login
Route::post('/login', function (\Illuminate\Http\Request $request) {
    // Simple authentication logic
    if ($request->email === 'admin@example.com' && $request->password === 'password') {
        // Set session
        $user = new \stdClass;
        $user->name = 'Admin User';
        $user->email = $request->email;
        session(['user' => $user]);

        return redirect('/')->with('success', 'Logged in successfully');
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
})->name('login.submit');

// Logout - clear session and redirect to login
Route::post('/logout', function () {
    session()->forget('user');

    return redirect('/login')->with('success', 'Logged out successfully');
})->name('logout');

// ===== HOME/ROOT ROUTE =====
// Root route - redirect to home if logged in, otherwise to login
Route::get('/', function () {
    if (session('user')) {
        return view('pages.dashboard.ecommerce', ['title' => 'Dashboard']);
    }

    return redirect('/login');
})->name('home');

// ===== DASHBOARD ROUTES (Protected) =====
Route::middleware('auth.custom')->group(function () {
    // dashboard pages
    Route::get('/dashboard', function () {
        return view('pages.dashboard.ecommerce', ['title' => 'E-commerce Dashboard']);
    })->name('dashboard');

    if (session('user')) {
        return view('auth.home', ['title' => 'Home']);
    }

    return redirect('/login');
})->name('home');

// ===== DASHBOARD ROUTES (Protected) =====
Route::middleware('auth.custom')->group(function () {
    // dashboard pages
    Route::get('/dashboard', function () {
        return view('pages.dashboard.ecommerce', ['title' => 'E-commerce Dashboard']);
    })->name('dashboard');

   
});
