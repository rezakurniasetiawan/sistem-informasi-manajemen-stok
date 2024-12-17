<?php

namespace App\Http\Controllers;

use App\Models\InboundItems;
use Illuminate\Http\Request;

class InboundItemsController extends Controller
{
    public function indexInboundItems(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = InboundItems::where('item_name', 'like', '%' . $request->search . '%')->paginate($entries);
        return view('dashboard.feature.inbound_items.index', compact('data'));
    }

    public function createInboundItems()
    {
        return view('dashboard.feature.inbound_items.add');
    }
}
