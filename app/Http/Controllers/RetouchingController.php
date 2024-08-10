<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\Retouching;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\RawMaterialLots;
use Illuminate\Support\Facades\DB;
use App\Models\RefinedMaterialLots;
use App\Models\RetouchingChecking;
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
            // $data = Retouching::all()->unique('ilc_cutting');
            $data = Retouching::select('ilc', 'ilc_cutting', 'id_supplier', 'tanggal',  'customer_grup', 'checking',  DB::raw('SUM(berat) as total_berat'), DB::raw('MAX(created_at) as created_at'))
                ->groupBy('ilc', 'ilc_cutting', 'id_supplier', 'tanggal', 'customer_grup', 'checking')
                ->orderBy('created_at', 'desc')
                ->get();

            $data->transform(function ($item) {
                // Mengambil ID terkait
                $relatedId = Retouching::where('ilc_cutting', $item->ilc_cutting)
                    ->where('id_supplier', $item->id_supplier)
                    ->where('customer_grup', $item->customer_grup)
                    // ->where('checking', $item->checking)
                    ->orderBy('created_at', 'desc')
                    ->value('id');
                $item->id = $relatedId;

                $item->tanggal = Carbon::parse($item->created_at)->format('d-m-Y');
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
                ->editColumn('checking', function ($row) {
                    if ($row->checking) {
                        return $row->checking . '%';
                    } else {
                        return '-';
                    }
                })
                ->addColumn('total_berat', function ($row) {
                    return $row->total_berat;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-start align-items-center">';
                    $btn .= '<a href="javascript:void(0);" onclick="hapus(' . $row->id . ')"><i class="text-danger ri-delete-bin-5-line mx-3"></i></a>';
                    $btn .= ' <a href="/product-log/' . $row->ilc . '"<i class="ri-arrow-right-line"></i></a>';
                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getBerat($ilc, $no_ikan)
    {
        $berat = Retouching::where('ilc', $ilc)->where('no_ikan', $no_ikan)->value('berat');
        return response()->json($berat);
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

    public function getNoIkan($ilc_cutting)
    {
        $noIkanList = RefinedMaterialLots::where('ilc_cutting', $ilc_cutting)
            ->orderBy('no_ikan', 'asc')
            ->distinct()
            ->pluck('no_ikan');

        return response()->json($noIkanList);
    }

    public function calculateLoin($ilc_cutting, $no_ikan)
    {
        // dd($ilc_cutting, $no_ikan);
        $beratLoin = RefinedMaterialLots::where('ilc_cutting', $ilc_cutting)
            ->where('no_ikan', $no_ikan)
            ->sum('berat');
        return response()->json($beratLoin);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ilc_cutting' => 'required',
            'no_ikan' => 'required',
            'berat' => 'required|numeric',
        ], [
            'ilc_cutting.required' => 'ILC Cutting Harus Diisi',
            'berat.required' => 'Berat Harus Diisi',
            'berat.numeric' => 'Berat Harus Angka',
            'no_ikan.required' => 'No Ikan Harus Diisi',
        ]);

        $validator->after(function ($validator) use ($request) {
            $existingEntry = Retouching::where('ilc_cutting', $request->ilc_cutting)
                ->where('no_ikan', $request->no_ikan)
                ->exists();

            if ($existingEntry) {
                $validator->errors()->add('ilc_cutting', 'ILC Cutting sudah ada.');
                $validator->errors()->add('no_ikan', 'No Ikan sudah ada.');
            }
        });

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

        $checking = Retouching::where('ilc', $ilc)->first('checking');
        if ($checking != null) {
            $checking = $checking->checking;
        }

        $save = new Retouching();
        $save->id_supplier = $id_supplier;
        $save->ilc = $ilc;
        $save->ilc_cutting = $request->ilc_cutting;
        $save->no_ikan = $request->no_ikan;
        $save->customer_grup = $customer_grup;
        $save->tanggal = $tanggal;
        $save->berat = $request->berat;
        $save->checking = $checking;
        $save->save();

        // save data to retouching_checking
        $getILC = RetouchingChecking::where('ilc', $ilc)->first('ilc');
        if ($getILC == null) {
            RetouchingChecking::create([
                'ilc' => $ilc
            ]);
        }

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
