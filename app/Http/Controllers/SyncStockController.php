<?php

namespace App\Http\Controllers;

use App\Models\MdGoods;
use App\Models\InboundItems;
use Illuminate\Http\Request;

class SyncStockController extends Controller
{
    public function syncStock(Request $request)
    {
        $entries = $request->get('entries', 10);
        $item_code = $request->get('item_code'); // Menggunakan get() untuk menghindari error jika tidak ada input
        $search = $request->get('search', ''); // Pastikan search tidak null

        // Query data berdasarkan item_code (jika dipilih)
        $query = InboundItems::join('md_goods', 'md_goods.id_mdgoods', '=', 'inbound_items.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'inbound_items.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'inbound_items.supplier_code')
            ->select(
                'inbound_items.*',
                'md_goods.code_mdgoods',
                'md_goods.name_mdgoods',
                'md_units.name_mdunit',
                'md_suppliers.code_mdsupplier'
            );

        if ($item_code) {
            $query->where('item_code', $item_code);
        }

        if ($search) {
            $query->where('md_goods.name_mdgoods', 'like', '%' . $search . '%');
        }

        $data = $query->paginate($entries);
        $totalData = $query->count();
        $items = MdGoods::all(); // Ambil semua barang untuk dropdown

        // dd($data);

        return view('dashboard.feature.sync.sync_stock', compact('data', 'totalData', 'items', 'item_code'));
    }
}
