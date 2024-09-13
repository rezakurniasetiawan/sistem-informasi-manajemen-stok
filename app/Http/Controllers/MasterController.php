<?php

namespace App\Http\Controllers;

use App\Models\MdUnit;
use App\Models\MdCategory;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    // Kategori
    public function indexCategory()
    {
        $data = MdCategory::get();
        $totalData = MdCategory::count();
        return view('dashboard.feature.masterdata.categories.index', compact('data', 'totalData'));
    }

    public function createCategory()
    {
        return view('dashboard.feature.masterdata.categories.add');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name_mdcategory' => 'required'
        ]);

        MdCategory::create($request->all());
        return redirect()->route('indexCategory')->with('success', 'Data berhasil ditambahkan');
    }

    public function editCategory($id)
    {
        $data = MdCategory::where('id_mdcategory', $id)->first();
        return view('dashboard.feature.masterdata.categories.update', compact('data'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name_mdcategory' => 'required'
        ]);

        $update = [
            'name_mdcategory' => $request->name_mdcategory
        ];

        MdCategory::where('id_mdcategory', '=', $id)->update($update);
        return redirect()->route('indexCategory')->with('success', 'Data berhasil diubah');
    }

    public function deleteCategory($id)
    {
        MdCategory::where('id_mdcategory', $id)->delete();
        return redirect()->route('indexCategory')->with('success', 'Data berhasil dihapus');
    }





    public function indexUnit()
    {
        $data = MdUnit::get();
        $totalData = MdUnit::count();
        return view('dashboard.feature.masterdata.units.index', compact('data', 'totalData'));
    }

    public function createUnit()
    {
        return view('dashboard.feature.masterdata.units.add');
    }

    public function storeUnit(Request $request)
    {
        $request->validate([
            'name_mdunit' => 'required'
        ]);

        MdUnit::create($request->all());
        return redirect()->route('indexUnit')->with('success', 'Data berhasil ditambahkan');
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
