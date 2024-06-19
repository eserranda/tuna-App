<?php

namespace App\Http\Controllers;

use App\Models\Receiving;
use Illuminate\Http\Request;

class ReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('receiving.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_supplier' => 'required|exists:suppliers,id',
            'no_plat' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        Receiving::create([
            'id_supplier' => $request->id_supplier,
            'no_plat' => $request->no_plat,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('receiving.index')->with('success', 'Receiving created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Receiving $receiving)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receiving $receiving)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receiving $receiving)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receiving $receiving)
    {
        //
    }
}
