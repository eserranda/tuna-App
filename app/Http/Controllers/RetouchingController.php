<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\Retouching;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RetouchingController extends Controller
{

    public function index()
    {
        return view('retouching.index');
    }

    public function getAllCutting(Request $request)
    {
        if ($request->ajax()) {
            $data = Cutting::latest('created_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="kodeILC(\'' . $row->ilc . '\')"><i class="ri-arrow-right-line"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
        //
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
    public function destroy(Retouching $retouching)
    {
        //
    }
}
