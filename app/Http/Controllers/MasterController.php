<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MdUnit;
use App\Models\MdCategory;
use App\Models\MdSupplier;
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



    public function goods()
    {
        return view('dashboard.feature.masterdata.goods.index');
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

    
    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('indexUser')->with('success', 'Data berhasil dihapus');
    }
}
