<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel; 


class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        // insert data dengan metode QUERY BUILDER
        // $data = [
        //     'kategori_kode' => 'SNK',
        //     'kategori_nama' => 'Snack/Makanan Ringan',
        //     'created_at' => now()
        // ];

        // DB::table('m_kategori')->insert($data);
        // return "Insert data baru berhasil";

        // update data dengan metode QUERY BUILDER
        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update([
        //     'kategori_nama' => 'Camilan'
        // ]);
        // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

        // delete data dengan metode QUERY BUILDER
        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

        // select data dengan metode QUERY BUILDER
        // $data = DB::table('m_kategori')->get();
        // return view('kategori', ['data' => $data]);
        return $dataTable->render('kategori.index');
    }
    public function create() 
    { 
        return view('kategori.create'); 
    } 

    public function store(Request $request) 
    { 
        KategoriModel::create([ 
            'kategori_kode' => $request->kodeKategori, 
            'kategori_nama' => $request->namaKategori, 
        ]); 

        return redirect('/kategori')->with('success', 'Kategori berhasil ditambahkan!'); 
    } 
    public function edit($id) {
        $kategori = KategoriModel::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }
    
    public function update(Request $request, $id) {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->update([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ]);
        return redirect('/kategori');
    }
    public function delete($id)
    {
        $find = KategoriModel::findOrFail($id);
        $find->delete();

        return redirect('/kategori');
    }

    
}
