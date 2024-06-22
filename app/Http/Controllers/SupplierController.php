<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\RawMaterialLots;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier.index');
    }

    public function nextNumber($no_ikan)
    {
        $lastLot = RawMaterialLots::where('no_ikan', $no_ikan)
            ->orderBy('no_ikan', 'desc')->first();

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

    public function getAllData(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::latest('created_at')->get();
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


    public function get()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    public function add()
    {
        return view('supplier.add');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'kode_batch' => 'required|string|max:3',
            'kode_supplier' => 'required|string|max:3',
            'nama_supplier' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
        ], [
            'kode_batch.required' => 'Kode Batch harus diisi.',
            'kode_batch.max' => 'Kode Batch maksimal 3 karakter.',
            'kode_supplier.required' => 'Kode Supplier harus diisi.',
            'kode_supplier.max' => 'Kode Supplier maksimal 3 karakter.',
            'nama_supplier.required' => 'Nama harus diisi.',
            'provinsi.required' => 'Provinsi harus diisi.',
            'kabupaten.required' => 'Kabupaten harus diisi.',
            'kelurahan.required' => 'Kelurahan harus diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data ke database
        $supplier = new Supplier();
        $supplier->kode_batch = $request->kode_batch;
        $supplier->kode_supplier = $request->kode_supplier;
        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->provinsi = $request->provinsi;
        $supplier->kabupaten = $request->kabupaten;
        $supplier->kelurahan = $request->kelurahan;
        $supplier->save();

        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier, $id)
    {
        try {
            $del_receiving = $supplier::findOrFail($id);
            $del_receiving->delete();

            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
