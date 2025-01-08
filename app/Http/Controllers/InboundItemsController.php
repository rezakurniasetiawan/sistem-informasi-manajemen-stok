<?php

namespace App\Http\Controllers;

use App\Models\InboundItems;
use App\Models\MdGoods;
use App\Models\MdSupplier;
use Illuminate\Http\Request;

class InboundItemsController extends Controller
{
    public function indexInboundItems(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = InboundItems::join('md_goods', 'md_goods.id_mdgoods', '=', 'inbound_items.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'inbound_items.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'inbound_items.supplier_code')
            ->select('inbound_items.*', 'md_goods.code_mdgoods', 'md_units.name_mdunit', 'md_suppliers.code_mdsupplier')
            ->where('item_name', 'like', '%' . $request->search . '%')->paginate($entries);
        $totalData = InboundItems::join('md_goods', 'md_goods.id_mdgoods', '=', 'inbound_items.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'inbound_items.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'inbound_items.supplier_code')
            ->select('inbound_items.*', 'md_goods.code_mdgoods', 'md_units.name_mdunit', 'md_suppliers.code_mdsupplier')
            ->where('item_name', 'like', '%' . $request->search . '%')->count();
            
        return view('dashboard.feature.inbound_items.index', compact('data', 'totalData'));
    }

    public function createInboundItems()
    {
        $lastInvoiceCode = InboundItems::orderBy('invoice_code', 'desc')->first();

        if ($lastInvoiceCode) {
            // Ambil kode terakhir, misalnya INV-00005
            $lastCode = $lastInvoiceCode->invoice_code;

            // Pisahkan prefix "INV-" dan angka
            $lastNumber = intval(substr($lastCode, 4));

            // Tambahkan 1 ke nomor terakhir
            $newNumber = $lastNumber + 1;

            // Format dengan leading zero, contoh: 00006
            $code = 'INV-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        } else {
            // Jika tidak ada data, mulai dari INV-00001
            $code = 'INV-00001';
        }

        $items = MdGoods::all();
        $suppliers = MdSupplier::all();
        return view('dashboard.feature.inbound_items.add', compact('code', 'items', 'suppliers'));
    }

    public function storeInboundItems(Request $request)
    {
        $request->validate([
            'input_date' => 'required',
            'user' => 'required',
            'invoice_code' => 'required',
            'item_code' => 'required',
            'item_name' => 'required',
            'unit' => 'required',
            'supplier_code' => 'required',
            'supplier_name' => 'required',
            'purchase_price' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
        ]);

        $data = [
            'input_date' => $request->input_date,
            'user' => $request->user,
            'invoice_code' => $request->invoice_code,
            'item_code' => $request->item_code,
            'item_name' => $request->item_name,
            'unit' => $request->unit,
            'supplier_code' => $request->supplier_code,
            'supplier_name' => $request->supplier_name,
            'purchase_price' => (int) preg_replace('/[^0-9]/', '', $request->purchase_price),
            'quantity' => $request->quantity,
            'total_price' => (int) preg_replace('/[^0-9]/', '', $request->total_price),
        ];

        InboundItems::create($data);
        return redirect()->route('indexInboundItems')->with('success', 'Data berhasil ditambahkan');
    }

    public function editInboundItems($id)
    {
        $data = InboundItems::where('id_inbound_items', $id)->first();
        $items = MdGoods::all();
        $suppliers = MdSupplier::all();
        return view('dashboard.feature.inbound_items.update', compact('data', 'items', 'suppliers'));
    }

    public function updateInboundItems(Request $request, $id)
    {
        $request->validate([
            'input_date' => 'required',
            'user' => 'required',
            'invoice_code' => 'required',
            'item_code' => 'required',
            'item_name' => 'required',
            'unit' => 'required',
            'supplier_code' => 'required',
            'supplier_name' => 'required',
            'purchase_price' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
        ]);

        $data = [
            'input_date' => $request->input_date,
            'user' => $request->user,
            'invoice_code' => $request->invoice_code,
            'item_code' => $request->item_code,
            'item_name' => $request->item_name,
            'unit' => $request->unit,
            'supplier_code' => $request->supplier_code,
            'supplier_name' => $request->supplier_name,
            'purchase_price' => (int) preg_replace('/[^0-9]/', '', $request->purchase_price),
            'quantity' => $request->quantity,
            'total_price' => (int) preg_replace('/[^0-9]/', '', $request->total_price),
        ];

        InboundItems::where('id_inbound_items', $id)->update($data);
        return redirect()->route('indexInboundItems')->with('success', 'Data berhasil diubah');
    }


    public function deleteInboundItems($id)
    {
        InboundItems::where('id_inbound_items', $id)->delete();
        return redirect()->route('indexInboundItems')->with('success', 'Data berhasil dihapus');
    }
}
