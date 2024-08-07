<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Packing;
use App\Models\ProductLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackingController extends Controller
{
    public function index()
    {
        return view('packing.index');
    }

    public function getAllDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Packing::latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('id_customer', function ($row) {
                    if ($row->id_customer) {
                        return $row->customer->nama;
                    } else {
                        return '-';
                    }
                })
                ->addColumn('id_produk', function ($row) {
                    if ($row->id_produk) {
                        return $row->produk->nama;
                    } else {
                        return '-';
                    }
                })
                ->editColumn('tanggal', function ($row) {
                    return Carbon::parse($row->tanggal)->format('d-m-Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-start align-items-center">';
                    $btn .= '<a href="javascript:void(0);"title="Hapus" onclick="hapus(' . $row->id . ')"><i class="ri-delete-bin-5-line mx-2"></i> </a>';
                    $btn .= ' <a href="/packing/customer-produk/' . $row->id_customer . '/' . $row->id_produk . '" "<i class="ri-arrow-right-line"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function customerProduk($id_customer, $id_produk)
    {
        $data = Packing::where('id_customer', $id_customer)
            ->where('id_produk', $id_produk)
            ->first();

        return view('packing.customer-produk', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_customer' => 'required',
            'id_produk' => 'required',
            'tanggal' => 'required|date',
            'kode' => 'required',
        ], [
            'required' => ':attribute wajib diisi',
        ]);

        $validator->after(function ($validator) use ($request) {
            $existingEntry = Packing::where('id_customer', $request->id_customer)
                ->where('id_produk', $request->id_produk)
                ->exists();

            if ($existingEntry) {
                $validator->errors()->add('id_customer', 'Customer sudah ada.');
                $validator->errors()->add('id_produk', 'Produk sudah ada.');
            }
        });


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        $save = Packing::create($request->all());
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

    // tampilan data produck pada produck log
    public function getAllDataProductLog(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductLog::latest('created_at')->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('id_produk', function ($row) {
                    if ($row->id_produk) {
                        return $row->produk->nama;
                    } else {
                        return '-';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="print(\'' . $row->id_produk  . '\', \'' . $row->ilc . '\')"><i class="ri-printer-fill mx-1"></i></a>';
                    $btn .= '<a href="javascript:void(0);" onclick="hapus(' . $row->id . ')"><i class="text-danger ri-delete-bin-5-line mx-3"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Packing $packing)
    {
        //
    }

    public function destroy(Packing $packing, $id)
    {
        try {
            $delete = $packing::findOrFail($id);
            $delete->delete();

            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}