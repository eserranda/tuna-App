<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{

    public function index()
    {
        return view('customer.index');
    }

    public function getAllData(Request $request)
    {
        if ($request->ajax()) {
            $data = Customers::latest('created_at')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="hapus(' . $row->id . ')"><i class="ri-delete-bin-5-line mx-3"></i></a>';
                    // $btn .= '<a href="javascript:void(0);" onclick="kodeILC(\'' . $row->ilc_cutting . '\')"><i class="ri-arrow-right-line"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add()
    {
        return view('customer.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'customer_group' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ], [
            'nama.required' => 'Nama harus diisi',

            'customer_group.required' => 'Grup customer harus diisi',
            'email.required' => 'Email harus diisi',
            'phone.required' => 'Nomor telepon harus diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $save = new Customers();
        $save->nama = $request->nama;
        $save->kode = $request->code;
        $save->customer_group = $request->customer_group;
        $save->email = $request->email;
        $save->phone = $request->phone;
        $save->alamat = $request->alamat;
        $save->save();

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    public function destroy(Customers $customer, $id)
    {
        try {
            $del_receiving = $customer::findOrFail($id);
            $del_receiving->delete();

            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
