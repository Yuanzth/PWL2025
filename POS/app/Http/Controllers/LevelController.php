<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index()
    {
        // insert data CUS
        DB::insert('INSERT INTO m_level (level_id, level_kode, level_nama, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?)', 
            [4, 'CUS', 'Pelanggan', now(), now()]
        );
        return 'Insert data baru berhasil';
    }
}
