<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\RawMaterialLots;
use App\Models\Receiving;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RawMaterialLotsController extends Controller
{
    public function getNoIkan($ilc)
    {
        $noIkanList = RawMaterialLots::where('ilc', $ilc)
            ->orderBy('no_ikan', 'asc')
            ->pluck('no_ikan');


        return response()->json($noIkanList);
    }

    public function nextNumber($ilc)
    {
        $lastLot = RawMaterialLots::where('ilc', $ilc)->orderBy('no_ikan', 'desc')->first();
        $nextNoIkan = $lastLot ? $lastLot->no_ikan + 1 : 1;

        return response()->json([
            'next_no_ikan' => $nextNoIkan,
        ]);
    }

    public function index()
    {
        //
    }

    function grading($ilc)
    {
        $data = Receiving::where('ilc', $ilc)->first();
        return view('receiving.grading', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function findOne(Request $request, $ilc)
    {
        if ($request->ajax()) {
            $data = RawMaterialLots::where('ilc', $ilc)->latest('created_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $btn = '<a href="/receiving/grading/' . $row->id . '"<i class="ri-delete-bin-5-line mx-3"></i></a>';
                    $btn = '<a href="javascript:void(0);" onclick="hapus(' . $row->id . ')"><i class="ri-delete-bin-5-line mx-3"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'berat' => 'required|numeric',
            'no_ikan' => 'required|numeric',
            'grade' => 'required',
        ], [
            'ilc.unique' => 'ILC Sudah Ada',
            'berat.required' => 'Berat Ikan Wajib Diisi',
            'berat.numeric' => 'Berat Ikan Harus Berupa Angka',
            'no_ikan.required' => 'Nomor Ikan Wajib Diisi',
            'no_ikan.numeric' => 'Nomor Ikan Harus Berupa Angka',
            'grade.required' => 'Grade Wajib Diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        RawMaterialLots::create([
            'ilc' => $request->ilc,
            'berat' => $request->berat,
            'no_ikan' => $request->no_ikan,
            'grade' => $request->grade,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berat Ikan Berhasil',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RawMaterialLots $rawMaterialLots)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RawMaterialLots $rawMaterialLots)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RawMaterialLots $rawMaterialLots)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RawMaterialLots $rawMaterialLots, $id)
    {
        try {
            $del_siswa = $rawMaterialLots::findOrFail($id);
            $del_siswa->delete();

            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
