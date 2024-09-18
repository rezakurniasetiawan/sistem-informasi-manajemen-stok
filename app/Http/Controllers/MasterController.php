<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MdUnit;
use App\Models\MdGoods;
use App\Models\MdCategory;
use App\Models\MdSupplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class MasterController extends Controller
{
    // ==============================================================================
    //                      CATEGORY                       
    // ==============================================================================

    public function indexCategory(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = MdCategory::where('name_mdcategory', 'like', '%' . $request->search . '%')->paginate($entries);
        $totalData = MdCategory::count();
        return view('dashboard.feature.masterdata.categories.index', compact('data', 'totalData'));
    }

    public function pdfCategory(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = MdCategory::where('name_mdcategory', 'like', '%' . $request->search . '%')->get(); // Mengambil semua data
        $totalData = MdCategory::count();

        // Membuat PDF menggunakan view
        $pdf = PDF::loadView('dashboard.feature.masterdata.categories.pdf', compact('data', 'totalData'));

        // Menyimpan PDF dengan nama yang diinginkan atau langsung menampilkan
        return $pdf->download('categories.pdf');
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

    // ==============================================================================
    //                       UNIT                       
    // ==============================================================================

    public function indexUnit(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = MdUnit::where('name_mdunit', 'like', '%' . $request->search . '%')->paginate($entries);
        $totalData = MdUnit::count();
        return view('dashboard.feature.masterdata.units.index', compact('data', 'totalData'));
    }

    public function pdfUnit(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = MdUnit::where('name_mdunit', 'like', '%' . $request->search . '%')->get(); // Mengambil semua data
        $totalData = MdUnit::count();

        // Membuat PDF menggunakan view
        $pdf = PDF::loadView('dashboard.feature.masterdata.units.pdf', compact('data', 'totalData'));

        // Menyimpan PDF dengan nama yang diinginkan atau langsung menampilkan
        return $pdf->download('units.pdf');
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

    public function editUnit($id)
    {
        $data = MdUnit::where('id_mdunit', $id)->first();
        return view('dashboard.feature.masterdata.units.update', compact('data'));
    }

    public function updateUnit(Request $request, $id)
    {
        $request->validate([
            'name_mdunit' => 'required'
        ]);

        $update = [
            'name_mdunit' => $request->name_mdunit
        ];

        MdUnit::where('id_mdunit', '=', $id)->update($update);
        return redirect()->route('indexUnit')->with('success', 'Data berhasil diubah');
    }

    public function deleteUnit($id)
    {
        MdUnit::where('id_mdunit', $id)->delete();
        return redirect()->route('indexUnit')->with('success', 'Data berhasil dihapus');
    }

    // ==============================================================================
    //                      SUPPLIER                       
    // ==============================================================================

    public function indexSupplier(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = MdSupplier::join('users', 'users.id', '=', 'md_suppliers.id_user')
            ->select('md_suppliers.*', 'users.name')
            ->where('name_mdsupplier', 'like', '%' . $request->search . '%')->paginate($entries);
        $totalData = MdSupplier::count();
        return view('dashboard.feature.masterdata.suppliers.index', compact('data', 'totalData'));
    }

    public function pdfSupplier(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = MdSupplier::join('users', 'users.id', '=', 'md_suppliers.id_user')
            ->select('md_suppliers.*', 'users.name')
            ->where('name_mdsupplier', 'like', '%' . $request->search . '%')->get(); // Mengambil semua data
        $totalData = MdSupplier::count();

        // Membuat PDF menggunakan view
        $pdf = PDF::loadView('dashboard.feature.masterdata.suppliers.pdf', compact('data', 'totalData'));

        // Menyimpan PDF dengan nama yang diinginkan atau langsung menampilkan
        return $pdf->download('suppliers.pdf');
    }

    public function createSupplier()
    {
        $code = 'SUP-' . date('YmdHis');
        return view('dashboard.feature.masterdata.suppliers.add', compact('code'));
    }

    public function storeSupplier(Request $request)
    {
        $idUser = Auth::user()->id;
        $request->validate([
            'created_mdsupplier' => 'required',
            'name_mdsupplier' => 'required',
            'address_mdsupplier' => 'required',
            'email_mdsupplier' => 'required',
            'phone_mdsupplier' => 'required'
        ]);

        $data = [
            'created_mdsupplier' => $request->created_mdsupplier,
            'id_user' => $idUser,
            'code_mdsupplier' => $request->code_mdsupplier,
            'name_mdsupplier' => $request->name_mdsupplier,
            'address_mdsupplier' => $request->address_mdsupplier,
            'email_mdsupplier' => $request->email_mdsupplier,
            'phone_mdsupplier' => $request->phone_mdsupplier
        ];

        MdSupplier::create($data);
        return redirect()->route('indexSupplier')->with('success', 'Data berhasil ditambahkan');
    }

    public function editSupplier($id)
    {
        $data = MdSupplier::join('users', 'users.id', '=', 'md_suppliers.id_user')
            ->select('md_suppliers.*', 'users.name')
            ->where('id_mdsupplier', $id)
            ->first();

        return view('dashboard.feature.masterdata.suppliers.update', compact('data'));
    }

    public function updateSupplier(Request $request, $id)
    {
        $request->validate([
            'name_mdsupplier' => 'required',
            'address_mdsupplier' => 'required',
            'email_mdsupplier' => 'required',
            'phone_mdsupplier' => 'required'
        ]);

        $update = [
            'name_mdsupplier' => $request->name_mdsupplier,
            'address_mdsupplier' => $request->address_mdsupplier,
            'email_mdsupplier' => $request->email_mdsupplier,
            'phone_mdsupplier' => $request->phone_mdsupplier
        ];

        MdSupplier::where('id_mdsupplier', '=', $id)->update($update);
        return redirect()->route('indexSupplier')->with('success', 'Data berhasil diubah');
    }

    public function deleteSupplier($id)
    {
        MdSupplier::where('id_mdsupplier', $id)->delete();
        return redirect()->route('indexSupplier')->with('success', 'Data berhasil dihapus');
    }

    // ==============================================================================
    //                        GOODS [Barang]                       
    // ==============================================================================

    public function indexGoods(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = MdGoods::join('md_categories', 'md_categories.id_mdcategory', '=', 'md_goods.idcategory_mdgoods')
            ->join('md_units', 'md_units.id_mdunit', '=', 'md_goods.idunit_mdgoods')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'md_goods.idsupplier_mdgoods')
            ->join('users', 'users.id', '=', 'md_goods.id_user')
            ->select('md_goods.*', 'md_categories.name_mdcategory', 'md_units.name_mdunit', 'md_suppliers.name_mdsupplier', 'users.name')
            ->where('name_mdgoods', 'like', '%' . $request->search . '%')->paginate($entries);

        // dd($data);
        $totalData = MdGoods::count();
        return view('dashboard.feature.masterdata.goods.index', compact('data', 'totalData'));
    }

    public function pdfGoods(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = MdGoods::join('md_categories', 'md_categories.id_mdcategory', '=', 'md_goods.idcategory_mdgoods')
            ->join('md_units', 'md_units.id_mdunit', '=', 'md_goods.idunit_mdgoods')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'md_goods.idsupplier_mdgoods')
            ->join('users', 'users.id', '=', 'md_goods.id_user')
            ->select('md_goods.*', 'md_categories.name_mdcategory', 'md_units.name_mdunit', 'md_suppliers.name_mdsupplier', 'users.name')
            ->where('name_mdgoods', 'like', '%' . $request->search . '%')->get(); // Mengambil semua data
        $totalData = MdGoods::count();

        // Membuat PDF menggunakan view
        $pdf = PDF::loadView('dashboard.feature.masterdata.goods.pdf', compact('data', 'totalData'));

        // Menyimpan PDF dengan nama yang diinginkan atau langsung menampilkan
        return $pdf->download('goods.pdf');
    }

    public function createGoods()
    {
        $code = 'BRG-' . date('YmdHis');
        $categories  = MdCategory::all();
        $units = MdUnit::all();
        $suppliers = MdSupplier::all();
        return view('dashboard.feature.masterdata.goods.add', compact('code', 'categories', 'units', 'suppliers'));
    }

    public function storeGoods(Request $request)
    {
        $request->validate([
            'created_mdgoods' => 'required',
            'id_user' => 'required',
            'code_mdgoods' => 'required',
            'name_mdgoods' => 'required',
            'idcategory_mdgoods' => 'required',
            'idunit_mdgoods' => 'required',
            'purchase_price_mdgoods' => 'required',
            'selling_price_mdgoods' => 'required',
            'idsupplier_mdgoods' => 'required',
            'code_supplier_mdgoods' => 'required',
            'stock_mdgoods' => 'required'
        ]);

        $data = [
            'created_mdgoods' => $request->created_mdgoods,
            'id_user' => Auth::user()->id,
            'code_mdgoods' => $request->code_mdgoods,
            'name_mdgoods' => $request->name_mdgoods,
            'idcategory_mdgoods' => $request->idcategory_mdgoods,
            'idunit_mdgoods' => $request->idunit_mdgoods,
            'purchase_price_mdgoods' => $request->purchase_price_mdgoods,
            'selling_price_mdgoods' => $request->selling_price_mdgoods,
            'idsupplier_mdgoods' => $request->idsupplier_mdgoods,
            'code_supplier_mdgoods' => $request->code_supplier_mdgoods,
            'stock_mdgoods' => $request->stock_mdgoods
        ];

        MdGoods::create($data);
        return redirect()->route('indexGoods')->with('success', 'Data berhasil ditambahkan');
    }

    public function editGoods($id)
    {
        $data = MdGoods::join('md_categories', 'md_categories.id_mdcategory', '=', 'md_goods.idcategory_mdgoods')
            ->join('md_units', 'md_units.id_mdunit', '=', 'md_goods.idunit_mdgoods')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'md_goods.idsupplier_mdgoods')
            ->join('users', 'users.id', '=', 'md_goods.id_user')
            ->select('md_goods.*', 'md_categories.name_mdcategory', 'md_units.name_mdunit', 'md_suppliers.name_mdsupplier', 'users.name')
            ->where('id_mdgoods', $id)
            ->first();

        $categories  = MdCategory::all();
        $units = MdUnit::all();
        $suppliers = MdSupplier::all();
        return view('dashboard.feature.masterdata.goods.update', compact('data', 'categories', 'units', 'suppliers'));
    }

    public function updateGoods(Request $request, $id)
    {
        $request->validate([
            'name_mdgoods' => 'required',
            'idcategory_mdgoods' => 'required',
            'idunit_mdgoods' => 'required',
            'purchase_price_mdgoods' => 'required',
            'selling_price_mdgoods' => 'required',
            'idsupplier_mdgoods' => 'required',
            'stock_mdgoods' => 'required'
        ]);

        $update = [
            'name_mdgoods' => $request->name_mdgoods,
            'idcategory_mdgoods' => $request->idcategory_mdgoods,
            'idunit_mdgoods' => $request->idunit_mdgoods,
            'purchase_price_mdgoods' => $request->purchase_price_mdgoods,
            'selling_price_mdgoods' => $request->selling_price_mdgoods,
            'idsupplier_mdgoods' => $request->idsupplier_mdgoods,
            'stock_mdgoods' => $request->stock_mdgoods
        ];

        MdGoods::where('id_mdgoods', '=', $id)->update($update);
        return redirect()->route('indexGoods')->with('success', 'Data berhasil diubah');
    }

    public function deleteGoods($id)
    {
        MdGoods::where('id_mdgoods', $id)->delete();
        return redirect()->route('indexGoods')->with('success', 'Data berhasil dihapus');
    }


    // ==============================================================================
    //                        USER                       
    // ==============================================================================

    public function indexUser(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = User::where('name', 'like', '%' . $request->search . '%')->paginate($entries);
        $totalData = User::count();
        return view('dashboard.feature.masterdata.users.index', compact('data', 'totalData'));
    }

    public function pdfUser(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = User::where('name', 'like', '%' . $request->search . '%')->get(); // Mengambil semua data
        $totalData = User::count();

        // Membuat PDF menggunakan view
        $pdf = PDF::loadView('dashboard.feature.masterdata.users.pdf', compact('data', 'totalData'));

        // Menyimpan PDF dengan nama yang diinginkan atau langsung menampilkan
        return $pdf->download('users.pdf');
    }

    public function createUser()
    {
        return view('dashboard.feature.masterdata.users.add');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ];

        User::create($data);
        return redirect()->route('indexUser')->with('success', 'Data berhasil ditambahkan');
    }

    public function editUser($id)
    {
        $data = User::where('id', $id)->first();
        return view('dashboard.feature.masterdata.users.update', compact('data'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
        ]);

        $update = [
            'name' => $request->name,
            'username' => $request->username,
        ];

        User::where('id', '=', $id)->update($update);
        return redirect()->route('indexUser')->with('success', 'Data berhasil diubah');
    }


    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('indexUser')->with('success', 'Data berhasil dihapus');
    }
}
