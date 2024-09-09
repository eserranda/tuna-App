<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Packing;
use App\Models\Customers;
use App\Models\ProductLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CustomerProduct;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

class PackingController extends Controller
{

    public function processQRCode(Request $request)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ambil role user yang sedang login
        $role = auth()->user()->roles->first();
        // dd($role->name);

        if ($role->name == 'super_admin' || $role->name == 'customer') {
            try {
                // Ambil kode QR dari query string
                $kode_qr = $request->query('kode');

                // Ambil id_customer dari user yang sedang login
                $id_customer = auth()->user()->id_customer;

                // Cari data Packing berdasarkan kode QR
                $packing = Packing::where('kode_qr', $kode_qr)
                    ->where('id_customer', $id_customer)
                    ->first();
                // dd($packing->customer->nama);

                if (!$packing) {
                    return response('Data not found', 404);
                }

                // Cek apakah id_customer dari user yang login sama dengan id_customer di Packing
                if ($id_customer == $packing->id_customer) {
                    // Dekripsi kode jika user memiliki hak akses
                    $kode_po = Crypt::decryptString($packing->kode);
                    $tanggal = Carbon::parse($packing->tanggal)->format('d-m-Y');

                    // Dapatkan produk terkait customer
                    $produk = CustomerProduct::where('id_customer', $id_customer)->get();

                    // Tampilkan data yang didekripsi
                    return view('detail-po.index', compact('kode_po', 'tanggal', 'packing', 'produk'));
                } else {
                    // Jika id_customer tidak cocok, tampilkan data tanpa mendekripsi kode_po
                    $kode_po = $packing->kode;

                    $produk = CustomerProduct::where('id_customer', $packing->id_customer)->get();


                    return view('detail-po.index', compact('kode_po', 'packing', 'produk'));
                }
            } catch (DecryptException $e) {
                // Jika terjadi kesalahan saat mendekripsi kode
                return response('Invalid QR Code', 400);
            }
        } else {
            abort(403, 'Unauthorized');
        }
    }


    // try {
    //     $kode_qr = $request->query('kode');

    //     $packing = Packing::where('kode_qr', $kode_qr)->first();
    //     $decryptedKode = Crypt::decryptString($packing->kode);

    //     $id_customer = Crypt::encryptString($packing->id_customer);
    //     $id_produk = Crypt::encryptString($packing->id_produk);

    //     if (!$packing) {
    //         return response('Data not found', 404);
    //     }

    //     // Jika ditemukan, kembalikan data packing
    //     return view('detail-po.index', compact('id_customer', 'id_produk', 'decryptedKode', 'packing'));
    //     // return view('detail-po.index', ['kode' => $decryptedKode, 'packing' => $packing]);
    // } catch (DecryptException $e) {
    //     return response('Invalid QR Code', 400);
    // }

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
                    $btn .= '<a href="javascript:void(0);"title="Hapus" onclick="hapus(' . $row->id . ')"><i class="text-danger ri-delete-bin-5-line"></i> </a>';
                    $btn .= '<a href="javascript:void(0);" onclick="printLabelPacking(\'' . $row->id_customer  . '\', \'' . $row->id_produk . '\', \'' . $row->kode . '\' )"><i class="ri-printer-fill mx-3"></i></a>';
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

        $kode = Crypt::decryptString($data->kode);

        return view('packing.customer-produk',  compact('data', 'kode'));
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

        $save = Packing::create(
            [
                'id_customer' => $request->id_customer,
                'id_produk' => $request->id_produk,
                'tanggal' => $request->tanggal,
                'kode' => Crypt::encryptString($request->kode), // Simpan kode terenkripsi
                'kode_qr' => Str::uuid(), // Simpan UUID atau bisa juga gunakan hash pendek
            ]
        );

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
