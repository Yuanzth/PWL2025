<?php

namespace App\Http\Controllers;

use App\Models\SalesModel;
use App\Models\DetailSalesModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalesController extends Controller
{
    // Menampilkan halaman utama
    public function index()
    {
        $activeMenu = 'penjualan';
        $breadcrumb = (object) [
            'title' => 'Data Transaksi Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        return view('penjualan.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb
        ]);
    }

    // Mengambil data untuk DataTables (POST /penjualan/list)
    public function list(Request $request)
    {
        try {
            $sales = SalesModel::with(['user', 'details'])
                ->select('t_penjualan.*');

            return DataTables::eloquent($sales)
                ->addIndexColumn()
                ->addColumn('penjualan_kode', fn($s) => $s->penjualan_kode)
                ->addColumn('pembeli', fn($s) => $s->pembeli)
                ->addColumn('penjualan_tanggal', fn($s) => date('d-m-Y H:i', strtotime($s->penjualan_tanggal)))
                ->addColumn('total', function($s) {
                    return 'Rp ' . number_format(
                        $s->details->sum(fn($detail) => $detail->harga * $detail->jumlah), 
                        0, ',', '.'
                    );
                })
                ->addColumn('nama', fn($s) => $s->user->nama ?? 'System')
                ->addColumn('aksi', function($s) {
                    return '<div class="text-center">' .
                        '<button onclick="showDetail(\'' . route('penjualan.show', $s->penjualan_id) . '\')" class="btn btn-sm btn-info mr-1">Detail</button>' .
                        '<button onclick="modalAction(\'' . route('penjualan.edit_ajax', $s->penjualan_id) . '\')" class="btn btn-sm btn-warning mr-1">Edit</button>' .
                        '<button onclick="confirmDelete(\'' . route('penjualan.delete_ajax', $s->penjualan_id) . '\')" class="btn btn-sm btn-danger">Hapus</button>' .
                        '</div>';
                })
                ->rawColumns(['aksi'])
                ->toJson();

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Menampilkan detail transaksi (GET /penjualan/{id})
    public function show($id)
    {
        $sale = SalesModel::with(['details.barang'])->find($id);
        return response()->json($sale);
    }

    // Method lainnya (create_ajax, store_ajax, dll) bisa ditambahkan di sini
    // ... 
}