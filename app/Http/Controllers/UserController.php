<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role');

        $users = User::when($search, function ($query, $search) {
            $query->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
        })
            ->when($roleFilter, function ($query, $roleFilter) {
                $query->where('role', $roleFilter);
            })
            ->whereIn('role', ['doctor', 'patient'])
            ->paginate(10);

        return view('admin.accounts.index', compact('users', 'search', 'roleFilter'));
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->role == 'admin' && auth()->user()->role != 'admin') {
            return redirect()->route('admin.accounts.index')->with('error', 'You cannot delete admin accounts.');
        }

        $user->delete();
        return redirect()->route('admin.accounts.index')->with('status', 'Account deleted successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if ($user->role == 'admin' && auth()->user()->role != 'admin') {
            return redirect()->route('admin.accounts.index')->with('error', 'You cannot edit admin accounts.');
        }

        return view('admin.accounts.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,doctor,patient',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only(['first_name', 'last_name', 'email', 'role']));

        return redirect()->route('admin.accounts.index')->with('status', 'Account updated successfully.');
    }
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->role == 'admin' && auth()->user()->role != 'admin') {
            return redirect()->route('admin.accounts.index')->with('error', 'You cannot change the status of admin accounts.');
        }

        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->route('admin.accounts.index')->with('status', 'Account status updated successfully.');
    }

    public function showInactiveAccounts()
    {
        $inactiveUsers = User::where('is_active', false)
            ->where('role', '!=', 'Admin')
            ->get();

        return view('admin.inactive-users', compact('inactiveUsers'));
    }



    public function destroyInactiveAccount(User $user)
    {
        $user->delete();
        return redirect()->route('admin.inactive-users')->with('success', 'User account deleted successfully!');
    }



}
