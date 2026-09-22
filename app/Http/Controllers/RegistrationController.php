<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function create(): View
    {
        return view('register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:32', 'regex:/^\+?[0-9\s\-()]{7,}$/'],
        ]);

        $user = User::create($validated);

        $link = $user->accessLink()->create([
            'token' => Str::random(64),
            'expires_at' => now()->addDays(7),
        ]);

        return redirect()->route('page-a.show', $link->token);
    }
}
