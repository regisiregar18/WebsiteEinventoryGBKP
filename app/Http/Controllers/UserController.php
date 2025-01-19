<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'phone' => 'required|numeric|min_digits:11|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($request->password != $request->confirm_password) {
            return redirect()->back()->with('failed', 'Konfirmasi password salah!');
        }

        User::create([
            'first_name' => Str::apa($request->first_name),
            'last_name' => Str::apa($request->last_name),
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = User::find($id);

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'phone' => 'required|numeric|min_digits:11|unique:users,phone,' . $data->id,
            'email' => 'required|email|unique:users,email,' . $data->id,
            'password' => 'required|min:6',
        ]);

        if ($request->password != $request->confirm_password) {
            return redirect()->back()->with('failed', 'Konfirmasi password salah!');
        }

        $data->update([
            'first_name' => Str::apa($request->first_name),
            'last_name' => Str::apa($request->last_name),
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Akun berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
