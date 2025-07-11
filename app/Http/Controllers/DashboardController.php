<?php

namespace App\Http\Controllers;

use App\Models\MdSupplier;
use Illuminate\Http\Request;
use App\Models\Stock;

class DashboardController extends Controller
{
    public function index()
    {
        // Query data masuk
        $dataMasuk = Stock::join('md_goods', 'md_goods.id_mdgoods', '=', 'stocks.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'stocks.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'stocks.supplier_code')
            ->where('stocks.type', 'inbound');

        // Query data keluar
        $dataKeluar = Stock::join('md_goods', 'md_goods.id_mdgoods', '=', 'stocks.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'stocks.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'stocks.supplier_code')
            ->where('stocks.type', 'outbound');

        // Query semua data stock
        $baseQuery = Stock::join('md_goods', 'md_goods.id_mdgoods', '=', 'stocks.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'stocks.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'stocks.supplier_code');

        // Hitung jumlah
        $countSupplier = MdSupplier::count();
        $countIncomingGoods = $dataMasuk->count();
        $countOutgoingGoods = $dataKeluar->count();
        $countStockFifo = $baseQuery->count();

        return view('dashboard.feature.home.index', compact(
            'countSupplier',
            'countIncomingGoods',
            'countOutgoingGoods',
            'countStockFifo'
        ));
    }
}