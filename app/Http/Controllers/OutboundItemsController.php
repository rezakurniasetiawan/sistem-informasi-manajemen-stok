<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OutboundItems;

class OutboundItemsController extends Controller
{
    public function indexOutboundItems(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = OutboundItems::join('md_goods', 'md_goods.id_mdgoods', '=', 'outbound_items.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'outbound_items.unit')
            ->select('outbound_items.*', 'md_goods.code_mdgoods', 'md_units.name_mdunit')
            ->where('item_name', 'like', '%' . $request->search . '%')->paginate($entries);
        $totalData = OutboundItems::count();
        return view('dashboard.feature.outbound_items.index', compact('data', 'totalData'));
    }
}
