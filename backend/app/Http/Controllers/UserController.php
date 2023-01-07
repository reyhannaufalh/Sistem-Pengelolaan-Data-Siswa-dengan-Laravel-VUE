<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        //get every user and return it as json data
        return User::get(['id','email','name','role']);
    }

    public function show($id)
    {
        //get user by id and return it as json data
        return User::where('id',$id)->get(['id','email','name','role']);
    }

    public function update(Request $request, $id)
    {
        //get user by id and update it
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    public function destroy($id)
    {
        //get user by id and delete it
        $user = User::find($id);
        $user->delete();
        return 204;
    }
}
