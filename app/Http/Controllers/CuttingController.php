<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\Receiving;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CuttingChecking;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CuttingController extends Controller
{
    public function index()
    {
        return view('cutting.index');
    }

    public function getAll(Request $request)
    {
        if ($request->ajax()) {
            $data = Cutting::latest('created_at')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('checking', function ($row) {
                    if ($row->checking != "") {
                        return ($row->checking . '%');
                    } else {
                        return "-";
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-start align-items-center">';
                    $btn = '<a href="javascript:void(0);" onclick="hapus(\'' . $row->id  . '\', \'' . $row->ilc . '\')"><i class="text-danger ri-delete-bin-5-line mx-2"></i></a>';
                    $btn .= ' <a href="/refined-material-lots/' . $row->ilc_cutting . '"<i class="ri-arrow-right-line"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getAllReceiving(Request $request)
    {
        if ($request->ajax()) {
            $data = Receiving::where('used', 0)->latest('created_at')->get();
            $data->transform(function ($item) {
                $item->tanggal = Carbon::parse($item->tanggal)->format('d-m-Y');
                return $item;
            });
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="kodeILC(\'' . $row->ilc . '\')"><i class="ri-arrow-right-line"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ilc' => 'required|string|max:255|unique:cuttings,ilc',
            'ekspor' => 'required|string|max:255',
        ], [
            'ilc.required' => 'ILC harus diisi',
            'ilc.unique' => 'ILC sudah ada',
            'ekspor.required' => 'Ekspor harus diisi',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $supplier =  Receiving::where('ilc', $request->ilc)->first();
        $id_supplier = $supplier->id_supplier;

        $ilc_cutting =  $request->ilc . '1';

        Cutting::create([
            'id_supplier' => $id_supplier,
            'ilc' => $request->ilc,
            'ilc_cutting' => $ilc_cutting,
            'ekspor' => $request->ekspor,
        ]);

        Receiving::where('ilc', $request->ilc)->update([
            'used' => true
        ]);

        CuttingChecking::create([
            'ilc' => $request->ilc
        ]);

        return response()->json([
            'success' => true,
        ]);
    }


    public function destroy(Cutting $cutting, $id, $ilc)
    {
        try {
            $del = $cutting::findOrFail($id);
            $del->delete();

            Receiving::where('ilc', $ilc)->update([
                'used' => false
            ]);


            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
