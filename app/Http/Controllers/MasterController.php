<?php

namespace App\Http\Controllers;

use App\Models\MdCategory;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    // Kategori
    public function kategori()
    {
        $data = MdCategory::get();
        return view('dashboard.feature.masterdata.categories.index', compact('data'));
    }

    public function addKategori()
    {
        return view('dashboard.feature.masterdata.categories.add');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'name_mdcategory' => 'required'
        ]);

        MdCategory::create($request->all());
        return redirect()->route('kategori')->with('success', 'Data berhasil ditambahkan');
    }

    public function editKategori($id)
    {
        $data = MdCategory::where('id_mdcategory', $id)->first();
        return view('dashboard.feature.masterdata.categories.update', compact('data'));
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'name_mdcategory' => 'required'
        ]);

        MdCategory::where('id_mdcategory', $id)->update($request->only('name_mdcategory'));
        return redirect()->route('kategori')->with('success', 'Data berhasil diubah');
    }





    public function unit()
    {
        return view('dashboard.feature.masterdata.units.index');
    }

    public function goods()
    {
        return view('dashboard.feature.masterdata.goods.index');
    }

    public function supplier()
    {
        return view('dashboard.feature.masterdata.suppliers.index');
    }

    public function user()
    {
        return view('dashboard.feature.masterdata.users.index');
    }
}
