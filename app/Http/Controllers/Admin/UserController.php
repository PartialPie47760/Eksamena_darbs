<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() { /* ... */ }
    public function edit(User $user) { /* ... */ }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in([User::ROLE_USER, User::ROLE_SUPREME_USER, User::ROLE_ADMIN])],
        ]);

        // no < 1 
        if ($user->id === Auth::id() && $request->input('role') !== User::ROLE_ADMIN && User::where('role', User::ROLE_ADMIN)->count() === 1) {
            return back()->withErrors('You cannot downgrade your role, you are the last admin.');
        }

        $user->update($request->only(['name', 'email', 'role'])); // Обновляем только эти поля
        return redirect()->route('admin.users.index')->with('success', 'User succesfuly updated!');
    }

    public function destroy(User $user) { /* ... */ }
    public function block(User $user) { /* ... */ }
    public function unblock(User $user) { /* ... */ }
}
