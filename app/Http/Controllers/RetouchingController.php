<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\Retouching;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RetouchingController extends Controller
{

    public function index()
    {
        return view('retouching.index');
    }

    public function getAll(Request $request)
    {
        if ($request->ajax()) {
            $data = Retouching::latest('created_at')->get();
            $data->transform(function ($item) {
                $item->tanggal = Carbon::parse($item->tanggal)->format('d-m-Y');
                return $item;
            });


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('id_supplier', function ($row) {
                    if ($row->id_supplier) {
                        return $row->supplier->nama_supplier;
                    } else {
                        return '-';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="hapus(' . $row->id . ')"><i class="ri-delete-bin-5-line mx-3"></i></a>';
                    $btn .= '<a href="javascript:void(0);" onclick="kodeILC(\'' . $row->ilc_cutting . '\')"><i class="ri-arrow-right-line"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getAllCutting(Request $request)
    {
        if ($request->ajax()) {
            $data = Cutting::latest('created_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="kodeILC(\'' . $row->ilc_cutting . '\')"><i class="ri-arrow-right-line"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'ilc_cutting' => 'required|unique:retouchings,ilc_cutting',
            'berat' => 'required|numeric',
        ], [
            'ilc_cutting.required' => 'ILC Cutting Harus Diisi',
            'ilc_cutting.unique' => 'ILC Cutting Sudah Ada',
            'berat.required' => 'Berat Harus Diisi',
            'berat.numeric' => 'Berat Harus Angka',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $cutting = Cutting::where('ilc_cutting', $request->ilc_cutting)->first();
        $id_supplier = $cutting->id_supplier;
        $ilc  = $cutting->ilc;
        $customer_grup = $cutting->ekspor;

        $tanggal = Carbon::now()->format('Y-m-d');


        $save = new Retouching();
        $save->id_supplier = $id_supplier;
        $save->ilc = $ilc;
        $save->ilc_cutting = $request->ilc_cutting;
        $save->customer_grup = $customer_grup;
        $save->tanggal = $tanggal;
        $save->berat = $request->berat;
        $save->save();

        if ($save) {
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Retouching $retouching)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Retouching $retouching)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Retouching $retouching)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Retouching $retouching, $id)
    {
        try {
            $del_receiving = $retouching::findOrFail($id);
            $del_receiving->delete();

            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
