<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        //get every user and return it as json data
        return Siswa::get(['id','nama', 'alamat', 'kota', 'provinsi', 'email']);
    }
    
    public function store(Request $request)
    {
        $data = $request->only('nama', 'alamat','kota', 'provinsi', 'email');
        $user = Siswa::create($data);
        if ($user) {
            return response($user, 201);
        }
        abort(400);
    }

    public function show($id)
    {
        //get user by id and return it as json data
        return Siswa::where('id',$id)->get(['id','nama', 'alamat', 'kota', 'provinsi', 'email']);
    }

    public function update(Request $request, $id)
    {
        //get user by id and update it
        $siswa = Siswa::find($id);
        $siswa->update($request->all());
        return $siswa;
    }

    public function destroy($id)
    {
        //get user by id and delete it
        $siswa = Siswa::find($id);
        $siswa->delete();
        return 204;
    }
}
