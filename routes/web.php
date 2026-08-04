<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Temporary developer route to auto-login and set local storage token
Route::get('/', function () {
    // Fetch the first user (seeded Admin) from the database using Eloquent ORM
    $user = User::first();

    if ($user) {
        // Programmatically login the user into the Laravel session
        Auth::login($user);

        // Inject the auth_token into client localStorage to satisfy the JS Route Guard
        return response("
            <script>
                localStorage.setItem('auth_token', 'dummy_developer_token');
                window.location.href = '/dashboard';
            </script>
        ");
    }

    // Fallback message if seeders have not been run yet
    return "Database is empty! Please run this command in terminal first: php artisan db:seed";
});

// Main dashboard route protected by Laravel auth middleware
Route::get('/dashboard', function () {
    // Retrieve the authenticated user with their loaded relationships
    $user = Auth::user();
    
    // Static dummy dataset for Class 6 - 10 school ERP metrics
    $data = [
        'total_students' => 845,
        'total_teachers' => 32
    ];

    // Load the correct view page (pages.dashboardPage) as configured in your structure
    return view('pages.dashboardPage', compact('user', 'data'));
})->name('dashboard')->middleware('auth');

// Dynamic Auth Post routes
Route::post('/logout', function() {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');