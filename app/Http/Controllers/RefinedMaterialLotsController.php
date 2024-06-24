<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\RawMaterialLots;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\RefinedMaterialLots;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RefinedMaterialLotsController extends Controller
{
    public function index($ilc_cutting)
    {
        $data = Cutting::where('ilc_cutting', $ilc_cutting)->first();
        $tanggal = Carbon::parse($data->created_at)->format('d-m-Y');
        $totalBerat = RawMaterialLots::where('ilc', $data->ilc)->sum('berat');
        $totalBeratGrade = RefinedMaterialLots::where('ilc_cutting',  $ilc_cutting)->sum('berat');
        $totalSisa = $totalBerat - $totalBeratGrade;

        return view('refined-material-lot.index', compact('data', 'tanggal', 'totalBerat', 'totalBeratGrade', 'totalSisa'));
    }

    public function getAll(Request $request, $ilc_cutting)
    {
        if ($request->ajax()) {
            $data = RefinedMaterialLots::where('ilc_cutting', $ilc_cutting)->latest('created_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="hapus(' . $row->id . ')"><i class="ri-delete-bin-5-line mx-3"></i></a>';
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
    public function show(RefinedMaterialLots $refinedMaterialLots)
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ilc_cutting' => 'required',
            'berat' => 'required|numeric',
            'no_ikan' => 'required|numeric',
            'no_loin' => 'required|numeric',
            'grade' => 'required',
        ], [
            'berat.required' => 'Berat Ikan Wajib Diisi',
            'berat.numeric' => 'Berat Ikan Harus Berupa Angka',
            'no_ikan.required' => 'Nomor Ikan Wajib Diisi',
            'no_ikan.numeric' => 'Nomor Ikan Harus Berupa Angka',
            'no_loin.required' => 'Nomor Loin Wajib Diisi',
            'no_loin.numeric' => 'Nomor Loin Harus Berupa Angka',
            'grade.required' => 'Grade Wajib Diisi',
        ]);

        $validator->after(function ($validator) use ($request) {
            $exists = RefinedMaterialLots::where('ilc_cutting', $request->ilc_cutting)
                ->where('no_ikan', $request->no_ikan)
                ->where('no_loin', $request->no_loin)
                ->exists();

            if ($exists) {
                return $validator->errors()->add('unique_combination', 'Nomor ikan dan nomor loin sudah ada');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data_cutting = Cutting::where('ilc_cutting', $request->ilc_cutting)->first();
        $id_cutting = $data_cutting->id;
        $id_supplier = $data_cutting->id_supplier;

        if ($data_cutting == null) {
            return response()->json([
                'success' => false,
                'errors' => 'ILC Tidak Ditemukan',
            ]);
        }

        $save =  RefinedMaterialLots::create([
            'id_supplier' => $id_supplier,
            'id_cutting' => $id_cutting,
            'ilc_cutting' => $request->ilc_cutting,
            'berat' => $request->berat,
            'no_ikan' => $request->no_ikan,
            'no_loin' => $request->no_loin,
            'grade' => $request->grade,
        ]);

        if ($save) {
            $totalBerat = RefinedMaterialLots::where('ilc_cutting', $request->ilc_cutting)->sum('berat');
            return response()->json([
                'success' => true,
                'totalBerat' => $totalBerat,
            ]);
        }
    }

    public function nextNumber($ilc_cutting, $no_ikan)
    {
        $lastLot = RefinedMaterialLots::where('ilc_cutting', $ilc_cutting)
            ->where('no_ikan', $no_ikan)
            ->orderBy('no_loin', 'desc')->first();

        if ($lastLot) {
            $nextNoIkan = $lastLot->no_loin + 1;
            if ($lastLot->no_loin == 4) {
                $nextNoIkan = 1;
            }
        } else {
            $nextNoIkan = 1;
        }

        return response()->json([
            'next_no_loin' => $nextNoIkan,
        ]);
    }

    public function edit(RefinedMaterialLots $refinedMaterialLots)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RefinedMaterialLots $refinedMaterialLots)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RefinedMaterialLots $refinedMaterialLots, $id)
    {
        try {
            $del_receiving = $refinedMaterialLots::findOrFail($id);
            $del_receiving->delete();

            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
