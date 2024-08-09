<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CustomerProduct;
use App\Models\PackingChecking;
use Illuminate\Support\Facades\Validator;

class CustomerProductController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ilc' => 'required|unique:customer_products,ilc',
            'berat' => 'required|numeric',
        ], [
            'ilc.required' => 'ILC harus diisi',
            'ilc.unique' => 'ILC sudah ada',
            'berat.required' => 'Berat harus diisi',
            'berat.numeric' => 'Berat harus berupa angka',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $tangal = Carbon::now('Asia/Makassar')->format('Y-m-d');

        $findOnePackingChecking = PackingChecking::where('ilc', $request->ilc)->first();
        if ($findOnePackingChecking == null) {
            PackingChecking::create([
                'ilc' => $request->ilc
            ]);
        }

        $save = CustomerProduct::create([
            'ilc' => $request->ilc,
            'id_customer' => $request->id_customer,
            'id_produk' => $request->id_produk,
            'berat' => $request->berat,
            'tanggal' => $tangal,
        ]);

        if ($save) {
            return response()->json([
                'success' => true
            ], 200);
        } else {
            return response()->json([
                'success' => false
            ], 500);
        }
    }


    public function getAllDatatable(Request $request, $id_customer)
    {
        if ($request->ajax()) {
            $data = CustomerProduct::where('id_customer', $id_customer)->latest('created_at')->get();
            return datatables()::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($row) {
                    return  Carbon::parse($row->tanggal)->format('d-m-Y');
                })
                ->addColumn('checking', function ($row) {
                    if ($row->checking != "") {
                        return ($row->checking . '%');
                    } else {
                        return "-";
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="hapus(' . $row->id . ')"><i class="ri-delete-bin-5-line mx-3"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function destroy(CustomerProduct $customerProduct, $id)
    {
        try {
            $del = $customerProduct::findOrFail($id);
            $del->delete();

            // Receiving::where('ilc', $ilc)->update([
            //     'used' => false
            // ]);


            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
