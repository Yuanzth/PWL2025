<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::with('level')->get();
        return view('user', ['data' => $user]);
    }
    public function tambah() 
    { 
        return view('user_tambah'); 
    }
    public function tambah_simpan(Request $request) 
    { 
        UserModel::create([ 
            'username' => $request->username, 
            'nama' => $request->nama, 
            'password' => Hash::make($request->password), // Menghapus tanda kutip yang salah
            'level_id' => $request->level_id 
        ]); 

        return redirect('/user'); 
    }

    public function ubah($id) 
    { 
        $user = UserModel::find($id); 
        return view('user_ubah', ['data' => $user]);
    }
    public function ubah_simpan($id, Request $request) 
    { 
        $user = UserModel::find($id);
        
        if (!$user) {
            return redirect('/user')->with('error', 'User tidak ditemukan!');
        }

        $user->username = $request->username;
        $user->nama = $request->nama;

        // Hanya update password jika diisi oleh pengguna
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->level_id = $request->level_id;
        $user->save();

        return redirect('/user')->with('success', 'Data user berhasil diperbarui!');
    }
    public function hapus ($id) 
    { 
        $user = UserModel::find($id); 
        $user->delete(); 
        return redirect('/user'); 
    }
    // public function profile($id, $name)
    // {
    //     return view('user.profile', compact('id', 'name'));
    // }
}
