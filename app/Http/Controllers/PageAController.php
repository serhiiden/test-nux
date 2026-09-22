<?php

namespace App\Http\Controllers;

use App\Models\AccessLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageAController extends Controller
{
    public function show(string $token): View
    {
        $link = $this->resolveLink($token);

        return view('page-a', ['link' => $link, 'user' => $link->user]);
    }

    public function regenerate(string $token): RedirectResponse
    {
        $link = $this->resolveLink($token);

        $link->update([
            'token' => Str::random(64),
            'expires_at' => now()->addDays(7),
        ]);

        return redirect()->route('page-a.show', $link->token);
    }

    public function deactivate(string $token): RedirectResponse
    {
        $this->resolveLink($token)->update(['is_active' => false]);

        return redirect()->route('home')->with('status', 'Your link has been deactivated.');
    }

    private function resolveLink(string $token): AccessLink
    {
        return AccessLink::where('token', $token)
            ->where('is_active', true)
            ->where('expires_at', '>', now())
            ->firstOr(fn () => abort(404));
    }
}
