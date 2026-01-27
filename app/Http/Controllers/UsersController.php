<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        'name'=>'required|string|max:255|unique:users',
        'email'=>'required|string|email|max:255|unique:users',
        'password'=>'required|string|min:8',
        'roles_id'=>'required',]);

        User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt($request->password),
        'roles_id'=>$request->roles_id,]);

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edituser = User::findOrFail($id);
        $roles = Role::all();
        return view('user.edit', compact('edituser', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'name'=>'required|string|max:255|unique:users,name,'.$id.',user_id',
        'email'=>'required|string|email|max:255|unique:users,email,'.$id.',user_id',
        'password'=>'nullable|string|min:8',
        'roles_id'=>'required|exists:roles,roles_id',]);

        $user = User::findOrFail($id);
        $user->update([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password ? bcrypt($request->password) : $user->password,
        'roles_id'=>$request->roles_id,]);
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('user_id', $id)->delete();
        return redirect()->route('user.index');
    }
}
