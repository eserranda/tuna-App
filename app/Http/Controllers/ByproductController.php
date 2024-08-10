<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Byproduct;
use App\Models\Receiving;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ByproductController extends Controller
{
    public function index()
    {
        return view('byproduct.index');
    }


    public function getAllDataReceiving()
    {
        if (request()->ajax()) {
            $data = Receiving::latest('created_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($row) {
                    return Carbon::parse($row->tanggal)->format('d-m-Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="getIlc(\'' . $row->ilc . '\')"><i class="ri-arrow-right-line"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getAll()
    {
        if (request()->ajax()) {
            $data = Byproduct::latest('created_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);"title="Hapus" onclick="hapus(' . $row->id . ')"><i class="text-danger ri-delete-bin-5-line"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ilc' => 'required|string|max:255',
            'berat' => 'required|numeric',
            'stage' => 'required|string|max:255',
        ], [
            'ilc.required' => 'ILC Wajib Diisi',
            'berat.required' => 'Berat Wajib Diisi',
            'berat.numeric' => 'Berat Harus Berupa Angka',
            'stage.required' => 'Stage Wajib Diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = Byproduct::create($request->all());
        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasilimpan'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Disimpan'
            ]);
        }
    }


    public function destroy(Byproduct $byproduct, $id)
    {
        try {
            $del = $byproduct::findOrFail($id);
            $del->delete();

            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}