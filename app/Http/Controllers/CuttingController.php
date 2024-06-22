<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\Receiving;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CuttingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cutting.index');
    }
    public function getAll(Request $request)
    {
        if ($request->ajax()) {
            $data = Cutting::latest('created_at')->get();

            // $data->transform(function ($item) {
            //     $item->created_at = Carbon::parse($item->created_at)->format('Y-m-d');
            //     return $item;
            // });
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="hapus(' . $row->id . ')"><i class="ri-delete-bin-5-line mx-3"></i></a>';
                    $btn .= ' <a href="/refined-material-lots/' . $row->ilc_cutting . '"<i class="ri-arrow-right-line"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getAllReceiving(Request $request)
    {
        if ($request->ajax()) {
            $data = Receiving::latest('created_at')->get();
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
            'ilc' => 'required|string|max:255',
            'ekspor' => 'required|string|max:255',
        ], [
            'ilc.required' => 'ILC harus diisi',
            'ekspor.required' => 'Ekspor harus diisi',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $ilc_cutting =  $request->ilc . '1';

        Cutting::create([
            'ilc' => $request->ilc,
            'ilc_cutting' => $ilc_cutting,
            'ekspor' => $request->ekspor,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cutting $cutting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cutting $cutting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cutting $cutting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cutting $cutting, $id)
    {
        try {
            $del_siswa = $cutting::findOrFail($id);
            $del_siswa->delete();

            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
