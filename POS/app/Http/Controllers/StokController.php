<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    // Menampilkan halaman utama stok
    public function index()
    {
        $activeMenu = 'stok';
        $breadcrumb = (object) [
            'title' => 'Data Stok',
            'list' => ['Home', 'Stok']
        ];

        $barang = BarangModel::select('barang_id', 'barang_nama')->get();

        return view('stok.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'barang' => $barang
        ]);
    }

    // Mengambil data stok untuk DataTables
    public function list(Request $request)
{
    try {
        $stok = StokModel::with(['barang', 'user'])
            ->select('t_stok.*'); // Gunakan select lengkap

        // Filter berdasarkan barang
        $barang_id = $request->input('filter_barang');
        if (!empty($barang_id)) {
            $stok->where('barang_id', $barang_id);
        }
        // Handle server-side parameters
        return DataTables::eloquent($stok)
            ->addIndexColumn()
            ->addColumn('barang_kode', fn($s) => $s->barang->barang_kode ?? '-')
            ->addColumn('barang_nama', fn($s) => $s->barang->barang_nama ?? '-')
            ->addColumn('nama', fn($s) => $s->user->nama ?? 'System')
            ->addColumn('updated_at', function($s) {
                return $s->updated_at->format('d-m-Y H:i');
            })
            ->addColumn('aksi', function($s) {
                return '<div class="text-center">'.
                    '<button onclick="modalAction(\''.url('/stok/'.$s->stok_id.'/edit_ajax').'\')" class="btn btn-sm btn-warning mr-1">Edit</button>'.
                    '<button onclick="modalAction(\''.url('/stok/'.$s->stok_id.'/delete_ajax').'\')" class="btn btn-sm btn-danger">Hapus</button>'.
                    '</div>';
            })
            ->rawColumns(['aksi'])
            ->toJson();

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }
    // Menampilkan form create dengan AJAX
    public function create_ajax()
    {
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        return view('stok.create_ajax', ['barang' => $barang]);
    }

    // Menyimpan data stok baru dengan AJAX
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => 'required|integer|exists:m_barang,barang_id',
                'stok_jumlah' => 'required|integer|min:0',
                'stok_tanggal' => 'required|date'
            ];

            $messages = [
                'barang_id.required' => 'Pilih barang wajib diisi',
                'stok_jumlah.min' => 'Stok tidak boleh negatif'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            StokModel::create([
                'barang_id' => $request->barang_id,
                'user_id' => auth()->user()->user_id, // Sesuaikan dengan auth system
                'stok_jumlah' => $request->stok_jumlah,
                'stok_tanggal' => $request->stok_tanggal
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Stok berhasil ditambahkan'
            ]);
        }
        return redirect('/');
    }

    // Menampilkan form edit dengan AJAX
    public function edit_ajax($id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        
        return view('stok.edit_ajax', [
            'stok' => $stok,
            'barang' => $barang
        ]);
    }

    // Update data dengan AJAX
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'stok_jumlah' => 'required|integer|min:0',
                'stok_tanggal' => 'required|date'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $stok = StokModel::find($id);
            
            if ($stok) {
                $stok->update([
                    'stok_jumlah' => $request->stok_jumlah,
                    'stok_tanggal' => $request->stok_tanggal
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Stok berhasil diperbarui'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data stok tidak ditemukan'
            ], 404);
        }
        return redirect('/');
    }

    // Menampilkan konfirmasi hapus dengan AJAX
    public function confirm_ajax($id)
    {
        $stok = StokModel::find($id);
        return view('stok.confirm_ajax', ['stok' => $stok]);
    }

    // Hapus data dengan AJAX
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            
            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Stok berhasil dihapus'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data stok tidak ditemukan'
            ], 404);
        }
        return redirect('/');
    }
}
