<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Google2FA;

class DashboardController extends Controller {
    public function show(): View {
        return view('dashboard')->with([
            'user' => Auth::user(),
            'secret_key' => Auth::user()->secret_key ?: Google2FA::generateSecretKey()
        ]);
    }

    public function save(Request $request) {
        if ($request->code) {
            if (Google2FA::verifyKey($request->secret_key, $request->code)) {
                Auth::user()->secret_key = $request->secret_key;
                Auth::user()->save();
            } else {
                return redirect(route("dashboard"))->withErrors([
                    '2fa' => 'Zadaný kód je nesprávny!'
                ]);
            }
        }

        return redirect(route("dashboard"));
    }

    public function delete() {
        Auth::user()->secret_key = null;
        Auth::user()->save();

        return redirect(route("dashboard"));
    }
}