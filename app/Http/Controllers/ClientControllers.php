<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ClientControllers extends Controller
{
    public function index()
    {
        $user = Auth::User();
        // dd($user->getRoleNames());
        $clients = User::role('Client')->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }
    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'number' => 'nullable|string|max:15|unique:users,number',
            'expiry_date' => 'nullable|date',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Check expiry for active status
        $isActive = false;
        if (!empty($data['expiry_date']) && \Carbon\Carbon::parse($data['expiry_date'])->isFuture()) {
            $isActive = true;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'number' => $data['number'] ?? null,
            'expiry_date' => $data['expiry_date'] ?? null,
            'is_active' => $isActive,
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('client');

        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
    }

    public function edit(User $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, User $client)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$client->id}",
            'number' => "nullable|string|max:15|unique:users,number,{$client->id}",
            'expiry_date' => 'nullable|date',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // If password is empty, don't update it
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Check expiry for active status
        $isActive = false;
        if (!empty($data['expiry_date']) && \Carbon\Carbon::parse($data['expiry_date'])->isFuture()) {
            $isActive = true;
        }
        $data['is_active'] = $isActive;

        $client->update($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');
    }
    public function destroy(User $client)
    {
        $client->delete();
        return back()->with('success', 'Client deleted successfully.');
    }

    public function custm(){
        return view('admin.clients.customer.index');
    }
       public function custm2(){
        return view('admin.clients.customer.index');
    }

}

// $user = \App\Models\User::create(['name'=>'Super Admin','email'=>'umair.577155@gmail.com','number'=>'03277361347','password'=>bcrypt('umair9646')]); $user->assignRole(roles: 'super_admin');