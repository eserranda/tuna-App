<?php

namespace App\Http\Controllers;

use App\Models\ProductLog;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class PrinterController extends Controller

{

    function productLogPrint($id_product, $ilc)
    {

        $getDataProduct = ProductLog::where('id_produk', $id_product)
            ->where('ilc', $ilc)
            ->first();

        $ilc = $getDataProduct->ilc;
        $id_product = $getDataProduct->id_produk;
        $nama_produk = $getDataProduct->produk->nama;
        $berat = $getDataProduct->berat;

        $join = $ilc . "-" . $id_product;

        $printerName = "p_parkir";
        try {
            // Menghubungkan ke printer
            $connector = new WindowsPrintConnector($printerName);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("\n");
            $printer->text($ilc);
            $printer->text("\n");
            $sizes = 10;
            $printer->qrCode($join, Printer::QR_ECLEVEL_L, $sizes);
            $printer->text(" \n");
            $printer->text($nama_produk . "\n");
            $printer->text("Berat: " . $berat . " Kg");

            $printer->setJustification();
            $printer->feed();

            // Cut & close
            $printer->cut();
            $printer->close();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return  response()->json(['success' => false]);
        }
    }
}
