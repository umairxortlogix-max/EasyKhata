<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'number' => ['nullable', 'string', 'max:15', 'unique:users,number'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_active' => ['sometimes', 'boolean'],
            'expiry_date' => ['nullable', 'date'],
        ]);
        $isActive = false;
        if ($request->expiry_date && \Carbon\Carbon::parse($request->expiry_date)->isFuture()) {
            $isActive = true;
        }

        // dd(vars: $request->all(),is_active:$isActive);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
             'is_active' => $isActive,
            // 'is_active' => $request->has(key: 'is_active') ? $request->is_active : false,
            'expiry_date' => $request->expiry_date,
            'password' => Hash::make($request->password),
        ]);

        // ✅ Assign default role directly by name
        $user->assignRole('client');

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }


}
