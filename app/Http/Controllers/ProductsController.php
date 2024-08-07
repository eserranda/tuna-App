<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ProductLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produk.index');
    }

    public function getAllData(Request $request)
    {
        if ($request->ajax()) {
            $data = Products::latest('created_at')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="hapus(' . $row->id . ')"><i class="text-danger ri-delete-bin-5-line mx-3"></i></a>';
                    // $btn .= '<a href="javascript:void(0);" onclick="kodeILC(\'' . $row->ilc_cutting . '\')"><i class="ri-arrow-right-line"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function get($customer_group)
    {
        $suppliers = Products::where('customer_group', $customer_group)->get();
        return response()->json($suppliers);
    }

    // tampilan data produck pada packing costuumers
    public function getAllDataProductLog(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductLog::latest('created_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('id_produk', function ($row) {
                    if ($row->id_produk) {
                        return $row->produk->nama;
                    } else {
                        return '-';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="kodeILC(\'' . $row->ilc . '\')"><i class="ri-arrow-right-line"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function productWithCustomerGroup(Request $request, $customer_group)
    {
        if ($request->ajax()) {
            $data = Products::where('customer_group', $customer_group)->latest('created_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="setProduct(\'' . $row->id . '\', \'' . $row->nama . '\')"><i class="ri-arrow-right-line"></i></a>';
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
            'kode' => 'required|unique:products,kode',
            'nama' => 'required|unique:products,nama',
            'customer_group' => 'required',
        ], [
            'kode.required' => 'Kode produk harus diisi',
            'kode.unique' => 'Kode produk sudah ada',
            'nama.required' => 'Nama produk harus diisi',
            'nama.unique' => 'Nama produk sudah ada',
            'customer_group.required' => 'Customer group harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->messages(),
            ], 422);
        }

        $products = Products::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'customer_group' => $request->customer_group,
        ]);

        if ($products) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan',
            ], 201);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Produk Gagal Disimpan',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products, $id)
    {
        try {
            $del_receiving = $products::findOrFail($id);
            $del_receiving->delete();

            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}