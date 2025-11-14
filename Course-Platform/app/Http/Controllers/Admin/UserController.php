<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
{
    
    $roles = ['teacher','student'];
    return view('admin.users.create', compact('roles'));
}


    public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'role'     => 'required|in:teacher,student', // admin tidak dibuat dari sini
        'is_active'=> 'nullable|boolean',
    ]);

    User::create([
        'name'      => $request->name,
        'email'     => $request->email,
        'password'  => Hash::make($request->password),
        'role'      => $request->role,
        'is_active' => $request->boolean('is_active', true),
    ]);

    return redirect()->route('users.index')
        ->with('status','User berhasil dibuat');
}

    public function edit(User $user)
    {
        $roles = ['admin','teacher','student'];
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role'  => 'required|in:admin,teacher,student',
            'is_active'=> 'nullable|boolean',
        ]);

        $data = $request->only('name','email','role');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'nullable|string|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('status','User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        // opsional: jangan hapus admin diri sendiri, dll
        $user->delete();
        return back()->with('status','User berhasil dihapus');
    }
}
