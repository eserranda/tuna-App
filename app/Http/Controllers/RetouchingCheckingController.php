<?php

namespace App\Http\Controllers;

use App\Models\Retouching;
use Illuminate\Http\Request;
use App\Models\RetouchingChecking;
use Illuminate\Support\Facades\Validator;

class RetouchingCheckingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RetouchingChecking::latest('created_at')->get();
            return datatables()::of($data)
                ->addIndexColumn()
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
                ->editColumn('penampakan', function ($row) {
                    if ($row->penampakan != "") {
                        return $row->penampakan;
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

        return view('retouching-checking.index');
    }

    public function update(Request $request, RetouchingChecking $retouchingChecking)
    {
        $validator = Validator::make($request->all(), [
            'penampakan' => 'required|numeric|min:0|max:4',
            'uji_lab' => 'required|numeric|min:0|max:4',
            'tekstur' => 'required|numeric|min:0|max:4',
            'bau' => 'required|numeric|min:0|max:4',
            'es' => 'required|numeric|min:0|max:4',
            'suhu' => 'required|numeric|min:0|max:4',
        ], [
            'required' => 'Nilai :attribute harus diisi.',
        ]);

        // dd(request()->all());

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        // Ambil nilai yang sudah tervalidasi
        $validatedData = $validator->validated();

        // dd(count($validatedData));
        // dd(array_sum($validatedData));
        // Hitung rata-rata nilai aktual (X)
        $averageX = array_sum($validatedData) / count($validatedData);

        // Hitung nilai kesesuaian (hasil) dalam persentase dan bulatkan
        $nilaiKesesuaian = round(($averageX / 4) * 100, 0);
        // dd($nilaiKesesuaian);

        $updateReceivingChecking = RetouchingChecking::where('id', $request->id)->update([
            'ilc' => $request->ilc,
            'penampakan' => $request->penampakan,
            'uji_lab' => $request->uji_lab,
            'tekstur' => $request->tekstur,
            'bau' => $request->bau,
            'es' => $request->es,
            'suhu' => $request->suhu,
            'hasil' => $nilaiKesesuaian,
        ]);

        $updateReceiving = Retouching::where('ilc', $request->ilc)->update([
            'checking' => $nilaiKesesuaian,
        ]);

        if (($updateReceivingChecking) && ($updateReceiving)) {
            return response()->json([
                'success' => true
            ], 201);
        } else {
            return response()->json([
                'success' => false
            ], 500);
        }
    }
}
