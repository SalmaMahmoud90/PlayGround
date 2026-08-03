<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::with('user')->paginate(10);
        return view('admin.owners.index', compact('owners'));
    }

    public function create()
    {
        return view('admin.owners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'owner',
            'is_active' => true,
        ]);

        Owner::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'is_verified' => $request->has('is_verified'),
        ]);

        return redirect()->route('admin.owners.index')
            ->with('success', 'Owner created successfully!');
    }

    public function edit(Owner $owner)
    {
        return view('admin.owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $owner->user_id,
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $owner->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->has('is_active'),
        ]);

        $owner->update([
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'is_verified' => $request->has('is_verified'),
        ]);

        return redirect()->route('admin.owners.index')
            ->with('success', 'Owner updated successfully!');
    }

    public function destroy(Owner $owner)
    {
        $owner->user->delete();
        $owner->delete();
        
        return redirect()->route('admin.owners.index')
            ->with('success', 'Owner deleted successfully!');
    }
}