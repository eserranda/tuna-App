<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use Illuminate\Http\Request;
use App\Models\CuttingChecking;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CuttingCheckingController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CuttingChecking::latest('created_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('whole', function ($row) {
                    if ($row->whole != "") {
                        return $row->whole;
                    } else {
                        return "-";
                    }
                })
                ->editColumn('uji_lab', function ($row) {
                    if ($row->uji_lab != "") {
                        return $row->uji_lab;
                    } else {
                        return "-";
                    }
                })
                ->editColumn('tekstur', function ($row) {
                    if ($row->tekstur != "") {
                        return $row->tekstur;
                    } else {
                        return "-";
                    }
                })
                ->editColumn('bau', function ($row) {
                    if ($row->bau != "") {
                        return $row->bau;
                    } else {
                        return "-";
                    }
                })
                ->editColumn('es', function ($row) {
                    if ($row->es != "") {
                        return $row->es;
                    } else {
                        return "-";
                    }
                })
                ->editColumn('suhu', function ($row) {
                    if ($row->suhu != "") {
                        return $row->suhu;
                    } else {
                        return "-";
                    }
                })
                ->editColumn('hasil', function ($row) {
                    if ($row->hasil != "") {
                        return ($row->hasil . '%');
                    } else {
                        return "-";
                    }
                })
                ->addColumn('action', function ($row) {
                    // $btn = '<a href="javascript:void(0);" onclick="update(' . $row->id . ')"><i class="ri-pencil-fill text-info"></i></a>';
                    $btn = '<a href="javascript:void(0);" onclick="update(\'' . $row->id  . '\', \'' . $row->ilc . '\')"><i class="ri-pencil-fill text-info"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('cutting-checking.index');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whole' => 'required|numeric|min:0|max:4',
            'uji_lab' => 'required|numeric|min:0|max:4',
            'tekstur' => 'required|numeric|min:0|max:4',
            'bau' => 'required|numeric|min:0|max:4',
            'es' => 'required|numeric|min:0|max:4',
            'suhu' => 'required|numeric|min:0|max:4',
        ], [
            'required' => 'Nilai :attribute harus diisi.',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        // Ambil nilai yang sudah tervalidasi
        $validatedData = $validator->validated();

        // Hitung rata-rata nilai aktual (X)
        $averageX = array_sum($validatedData) / count($validatedData);

        // Hitung nilai kesesuaian (hasil) dalam persentase dan bulatkan
        $nilaiKesesuaian = round(($averageX / 4) * 100, 0);

        $update = CuttingChecking::where('id', $request->id)->update([
            'ilc' => $request->ilc,
            'whole' => $request->whole,
            'uji_lab' => $request->uji_lab,
            'tekstur' => $request->tekstur,
            'bau' => $request->bau,
            'es' => $request->es,
            'suhu' => $request->suhu,
            'hasil' => $nilaiKesesuaian,
        ]);
        $updateReceiving = Cutting::where('ilc', $request->ilc)->update([
            'checking' => $nilaiKesesuaian,
        ]);

        if (($updateReceiving) && ($update)) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
            ], 500);
        }
    }
}
