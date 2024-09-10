<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function kategori()
    {
        return view('dashboard.feature.masterdata.category');
    }
    public function unit()
    {
        return view('dashboard.feature.masterdata.unit');
    }

    public function goods()
    {
        return view('dashboard.feature.masterdata.goods');
    }

    public function supplier()
    {
        return view('dashboard.feature.masterdata.supplier');
    }

    public function user()
    {
        return view('dashboard.feature.masterdata.user');
    }
}
