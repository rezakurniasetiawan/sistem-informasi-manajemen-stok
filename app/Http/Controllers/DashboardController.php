<?php

namespace App\Http\Controllers;

use App\Models\MdSupplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $countSupplier = MdSupplier::count();
        $countIncomingGoods = 0;
        $countOutgoingGoods = 0;
        $countStockFifo = 0;
        return view('dashboard.feature.home.index', compact('countSupplier', 'countIncomingGoods', 'countOutgoingGoods', 'countStockFifo'));
    }
}
