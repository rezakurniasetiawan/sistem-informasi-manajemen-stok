<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\MdGoods;
use App\Models\MdSupplier;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StockInboundController extends Controller
{
    // ===============================
    // BARANG MASUK (INBOUND)
    // ===============================

    public function indexInboundItems(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = Stock::join('md_goods', 'md_goods.id_mdgoods', '=', 'stocks.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'stocks.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'stocks.supplier_code')
            ->select('stocks.*', 'md_goods.code_mdgoods', 'md_units.name_mdunit', 'md_suppliers.code_mdsupplier')
            ->where('type', 'inbound')
            ->where('item_name', 'like', '%' . $request->search . '%')->paginate($entries);
        $totalData = $data->total();

        return view('dashboard.feature.inbound_items.index', compact('data', 'totalData'));
    }

    public function createInboundItems()
    {
        // $lastInvoiceCode = InboundItems::orderBy('invoice_code', 'desc')->first();
        $lastInvoiceCode = Stock::where('type', 'inbound')->orderBy('invoice_code', 'desc')->first();

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
        // Validasi input dengan custom message
        $request->validate([
            'item_code'      => 'required|string|max:50',
            'item_name'      => 'required|string|max:150',
            'unit'           => 'required|string|max:50',
            'supplier_code'  => 'required|string|max:50',
            'supplier_name'  => 'required|string|max:150',
            'purchase_price' => 'required|string',
            'quantity'       => 'required|integer|min:1',
        ], [
            'item_code.required'      => 'Kode barang wajib diisi.',
            'item_name.required'      => 'Nama barang wajib diisi.',
            'unit.required'           => 'Satuan barang wajib diisi.',
            'supplier_code.required'  => 'Kode supplier wajib diisi.',
            'supplier_name.required'  => 'Nama supplier wajib diisi.',
            'purchase_price.required' => 'Harga beli wajib diisi.',
            'quantity.required'       => 'Jumlah barang wajib diisi.',
            'quantity.integer'        => 'Jumlah barang harus berupa angka.',
            'quantity.min'            => 'Jumlah barang minimal 1.',
        ]);

        try {
            // Sanitasi harga beli
            $purchasePrice = (int) str_replace('.', '', preg_replace('/[^0-9.]/', '', $request->purchase_price));
            $quantity = (int) $request->quantity;
            $totalPrice = $purchasePrice * $quantity;

            // Simpan data ke database
            $data = Stock::create([
                'input_date'     => now(),
                'user'           => auth()->user()?->name ?? 'Unknown',
                'invoice_code'   => 'IN-' . time(),
                'item_code'      => $request->item_code,
                'item_name'      => $request->item_name,
                'unit'           => $request->unit,
                'supplier_code'  => $request->supplier_code,
                'supplier_name'  => $request->supplier_name,
                'purchase_price' => $purchasePrice,
                'quantity'       => $quantity,
                'quantity_out' => $quantity,
                'total_price'    => $totalPrice,
                'total_price_after' => $quantity * $purchasePrice,
                'type'           => 'inbound',
            ]);

            return redirect()->route('indexInboundItems')->with('success', 'Data stok berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Jika terjadi error selain validasi
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function deleteInboundItems($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return redirect()->route('indexInboundItems')->with('success', 'Data stok berhasil dihapus.');
    }

    public function editInboundItems($id)
    {
        $data = Stock::where('id', $id)->first();
        $items = MdGoods::all();
        $suppliers = MdSupplier::all();
        return view('dashboard.feature.inbound_items.update', compact('data', 'items', 'suppliers'));
    }

    public function updateInboundItems(Request $request, $id)
    {
        $purchasePrice = (int) str_replace('.', '', preg_replace('/[^0-9.]/', '', $request->purchase_price));
        // dd($purchasePrice);
        $quantity = (int) $request->quantity;
        $totalPrice = $purchasePrice * $quantity;
        // dd($quantity);

        $data = [
            'input_date'     => $request->input_date,
            'user'           => $request->user,
            'invoice_code'   => $request->invoice_code,
            'item_code'      => $request->item_code,
            'item_name'      => $request->item_name,
            'unit'           => $request->unit,
            'supplier_code'  => $request->supplier_code,
            'supplier_name'  => $request->supplier_name,
            'purchase_price' => $purchasePrice,
            'quantity'       => $quantity,
            'quantity_out' => $quantity,
            'total_price'    => $totalPrice,
            'total_price_after' => $quantity * $purchasePrice,
            'type'           => 'inbound',

        ];

        Stock::where('id', $id)->update($data);
        return redirect()->route('indexInboundItems')->with('success', 'Data stok berhasil diubah.');
    }

    public function pdfInboundItems(Request $request)
    {
        $data = Stock::join('md_goods', 'md_goods.id_mdgoods', '=', 'stocks.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'stocks.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'stocks.supplier_code')
            ->select('stocks.*', 'md_goods.code_mdgoods', 'md_units.name_mdunit', 'md_suppliers.code_mdsupplier')
            ->where('type', 'inbound')
            ->where('item_name', 'like', '%' . $request->search . '%')->get();
        $totalData = $data->count();
        $pdf = PDF::loadView('dashboard.feature.reports.inbound_report_pdf', compact('data', 'totalData'));
        return $pdf->download('inbound_items.pdf');
    }

    // Laporan Barang Masu
    public function reportInboundItems(Request $request)

    {

        $datenow = date('Y-m-d');
        $startDate = $request->get('start_date', $datenow);
        $endDate = $request->get('end_date', date('Y-m-d', strtotime($startDate . ' + 7 days')));
        $entries = $request->get('entries', 10);
        $data = Stock::join('md_goods', 'md_goods.id_mdgoods', '=', 'stocks.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'stocks.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'stocks.supplier_code')
            ->select('stocks.*', 'md_goods.code_mdgoods', 'md_units.name_mdunit', 'md_suppliers.code_mdsupplier')
            ->where('type', 'inbound')
            ->whereBetween('input_date', [$startDate, $endDate])
            ->where('item_name', 'like', '%' . $request->search . '%')->paginate($entries);
        $totalData =  $data->total();
        return view('dashboard.feature.reports.inbound_report', compact('data', 'totalData', 'startDate', 'endDate'));
    }


    // ===============================
    // BARANG KELUAR (OUTBOUND)
    // ===============================

    public function indexOutboundItems(Request $request)
    {
        $entries = $request->get('entries', 10);
        $data = Stock::join('md_goods', 'md_goods.id_mdgoods', '=', 'stocks.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'stocks.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'stocks.supplier_code')
            ->select('stocks.*', 'md_goods.code_mdgoods', 'md_units.name_mdunit', 'md_suppliers.code_mdsupplier')
            ->where('type', 'outbound')
            ->where('item_name', 'like', '%' . $request->search . '%')->paginate($entries);
        $totalData = $data->total();
        return view('dashboard.feature.outbound_items.index', compact('data', 'totalData'));
    }

    public function createOutboundItems()
    {
        $lastInvoiceCode = Stock::where('type', 'outbound')->orderBy('invoice_code', 'desc')->first();

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
        return view('dashboard.feature.outbound_items.add', compact('code', 'items', 'suppliers'));
    }

    public function storeOutboundItems(Request $request)
    {
        $request->validate([
            'item_code' => 'required|string|max:50',
            'quantity'  => 'required|integer|min:1',
        ], [
            'item_code.required' => 'Kode barang wajib diisi.',
            'quantity.required'  => 'Jumlah barang wajib diisi.',
            'quantity.integer'   => 'Jumlah barang harus berupa angka.',
            'quantity.min'       => 'Jumlah barang minimal 1.',
        ]);

        try {
            $purchasePrice = (int) str_replace('.', '', preg_replace('/[^0-9.]/', '', $request->purchase_price));
            $itemCode = $request->item_code;
            $requestedQty = (int) $request->quantity;
            $user = auth()->user()?->name ?? 'Unknown';

            // Ambil stok masuk dengan FIFO
            $inbounds = Stock::where('item_code', $itemCode)
                ->where('type', 'inbound')
                ->where('quantity', '>', 0)
                ->orderBy('input_date', 'asc')
                ->get();

            $totalAvailable = $inbounds->sum('quantity');

            if ($requestedQty > $totalAvailable) {
                return redirect()->back()->withInput()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $totalAvailable);
            }

            foreach ($inbounds as $inbound) {
                if ($requestedQty <= 0) break;

                $usedQty = min($inbound->quantity_out, $requestedQty);
                $inbound->quantity_out -= $usedQty;
                // update total_price_after
                $inbound->total_price_after = $inbound->quantity_out * $inbound->purchase_price;
                $inbound->save();

                $quantityAfter = $inbound->quantity_out; // sisa stok setelah pengurangan

                Stock::create([
                    'input_date'     => now(),
                    'user'           => $user,
                    'invoice_code'   => 'OUT-' . time(),
                    'item_code'      => $inbound->item_code,
                    'item_name'      => $inbound->item_name,
                    'unit'           => $inbound->unit,
                    'supplier_code'  => $inbound->supplier_code,
                    'supplier_name'  => $inbound->supplier_name,
                    'purchase_price' => $purchasePrice,
                    'quantity'       => 0, // karena ini record outbound
                    'quantity_out'   => $usedQty,
                    'quantity_after' => $quantityAfter,
                    'total_price'    => $usedQty * $purchasePrice,
                    'type'           => 'outbound',
                ]);

                $requestedQty -= $usedQty;
            }

            return redirect()->route('indexOutboundItems')->with('success', 'Barang berhasil dikeluarkan dari stok.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat proses stok keluar: ' . $e->getMessage());
        }
    }


    public function syncStockFIFO(Request $request)
    {
        $entries = $request->get('entries', 10);
        $item_code = $request->get('item_code');
        $search = $request->get('search', '');

        // Ambil query dasar
        $baseQuery = Stock::join('md_goods', 'md_goods.id_mdgoods', '=', 'stocks.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'stocks.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'stocks.supplier_code')
            ->select(
                'stocks.*',
                'md_goods.code_mdgoods',
                'md_goods.name_mdgoods',
                'md_units.name_mdunit',
                'md_suppliers.code_mdsupplier'
            );

        // Filter berdasarkan item_code
        if (!empty($item_code)) {
            $baseQuery->where('stocks.item_code', $item_code);
        }

        // Filter berdasarkan nama barang
        if (!empty($search)) {
            $baseQuery->where('md_goods.name_mdgoods', 'like', '%' . $search . '%');
        }

        // Clone query untuk menghitung total
        $totalData = (clone $baseQuery)->count();

        // Data paginated
        $data = $baseQuery->orderBy('stocks.input_date')->paginate($entries);

        // Semua barang untuk dropdown
        $items = MdGoods::all();

        // Data stocks FIFO (tanpa paginate)
        $stocks = Stock::when($item_code, fn($q) => $q->where('item_code', $item_code))
            ->orderBy('input_date')
            ->get();

        return view('dashboard.feature.sync.sync_stock', compact(
            'data',
            'stocks',
            'totalData',
            'items',
            'item_code',
            'search',
            'entries'
        ));
    }

    public function pdfSyncStockFIFO(Request $request)
    {
        $item_code = $request->get('item_code');
        $search = $request->get('search', '');

        // Ambil query dasar
        $baseQuery = Stock::join('md_goods', 'md_goods.id_mdgoods', '=', 'stocks.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'stocks.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'stocks.supplier_code')
            ->select(
                'stocks.*',
                'md_goods.code_mdgoods',
                'md_goods.name_mdgoods',
                'md_units.name_mdunit',
                'md_suppliers.code_mdsupplier'
            );

        // Filter berdasarkan item_code
        if (!empty($item_code)) {
            $baseQuery->where('stocks.item_code', $item_code);
        }

        // Filter berdasarkan nama barang
        if (!empty($search)) {
            $baseQuery->where('md_goods.name_mdgoods', 'like', '%' . $search . '%');
        }

        // Ambil data yang sudah diurutkan berdasarkan tanggal
        $stocks = $baseQuery->orderBy('stocks.input_date')->get();

        // Perhitungan FIFO dan saldo
        $saldoQty = 0;
        $saldoHarga = 0;
        $saldoTotal = 0;

        $totalInQty = 0;
        $totalInHarga = 0;
        $totalOutQty = 0;
        $totalOutHarga = 0;

        foreach ($stocks as $stock) {
            $inQty = $stock->type == 'inbound' ? $stock->quantity : null;
            $inHarga = $stock->type == 'inbound' ? $stock->purchase_price : null;
            $inTotal = $inQty && $inHarga ? $inQty * $inHarga : null;

            $outQty = $stock->type == 'outbound' ? $stock->quantity_out : null;
            $outHarga = $stock->type == 'outbound' ? $stock->purchase_price : null;
            $outTotal = $outQty && $outHarga ? $outQty * $outHarga : null;

            if ($inQty) {
                $saldoQty += $inQty;
                $saldoHarga = $inHarga; // asumsi harga terakhir
                $saldoTotal += $inTotal;

                $totalInQty += $inQty;
                $totalInHarga += $inTotal;
            }

            if ($outQty) {
                $saldoQty -= $outQty;
                $saldoTotal -= $outTotal;

                $totalOutQty += $outQty;
                $totalOutHarga += $outTotal;
            }

            // Tambahkan properti sementara untuk view
            $stock->inQty = $inQty;
            $stock->inHarga = $inHarga;
            $stock->inTotal = $inTotal;

            $stock->outQty = $outQty;
            $stock->outHarga = $outHarga;
            $stock->outTotal = $outTotal;

            $stock->saldoQty = $saldoQty;
            $stock->saldoHarga = $saldoHarga;
            $stock->saldoTotal = $saldoTotal;
        }

        // Kirim ke view
        $pdf = PDF::loadView('dashboard.feature.sync.sync_stock_pdf', [
            'stocks' => $stocks,
            'totalInQty' => $totalInQty,
            'totalInHarga' => $totalInHarga,
            'totalOutQty' => $totalOutQty,
            'totalOutHarga' => $totalOutHarga,
            'saldoQty' => $saldoQty,
            'saldoTotal' => $saldoTotal
        ]);

        return $pdf->download('sync_stock_fifo.pdf');
    }


    public function reportOutboundItems(Request $request)
    {
        $datenow = date('Y-m-d');
        $startDate = $request->get('start_date', $datenow);
        $endDate = $request->get('end_date', date('Y-m-d', strtotime($startDate . ' + 7 days')));
        $entries = $request->get('entries', 10);
        $data = Stock::join('md_goods', 'md_goods.id_mdgoods', '=', 'stocks.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'stocks.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'stocks.supplier_code')
            ->select('stocks.*', 'md_goods.code_mdgoods', 'md_units.name_mdunit', 'md_suppliers.code_mdsupplier')
            ->where('type', 'outbound')
            ->whereBetween('input_date', [$startDate, $endDate])
            ->where('item_name', 'like', '%' . $request->search . '%')->paginate($entries);
        $totalData = $data->total();

        return view('dashboard.feature.reports.outbound_report', compact('data', 'totalData', 'startDate', 'endDate'));
    }

    public function deleteOutboundItems($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return redirect()->route('indexOutboundItems')->with('success', 'Data stok berhasil dihapus.');
    }

    public function editOutboundItems($id)
    {
        $data = Stock::where('id', $id)->first();
        $items = MdGoods::all();
        $suppliers = MdSupplier::all();
        return view('dashboard.feature.outbound_items.update', compact('data', 'items', 'suppliers'));
    }

    public function updateOutboundItems(Request $request, $id)
    {
        $request->validate([
            'item_code' => 'required|string|max:50',
            'quantity'  => 'required|integer|min:1',
        ], [
            'item_code.required' => 'Kode barang wajib diisi.',
            'quantity.required'  => 'Jumlah barang wajib diisi.',
            'quantity.integer'   => 'Jumlah barang harus berupa angka.',
            'quantity.min'       => 'Jumlah barang minimal 1.',
        ]);

        $purchasePrice = (int) str_replace('.', '', preg_replace('/[^0-9.]/', '', $request->purchase_price));
        $quantity = (int) $request->quantity;
        $totalPrice = $purchasePrice * $quantity;

        // Update data
        Stock::where('id', $id)->update([
            'input_date'     => $request->input_date,
            'user'           => $request->user,
            'invoice_code'   => $request->invoice_code,
            'item_code'      => $request->item_code,
            'item_name'      => $request->item_name,
            'unit'           => $request->unit,
            'supplier_code'  => $request->supplier_code,
            'supplier_name'  => $request->supplier_name,
            'purchase_price' => $purchasePrice,
            'quantity'       => 0, // karena ini record outbound
            'quantity_out'   => $quantity,
            'total_price'    => $totalPrice,
            'type'           => 'outbound',
        ]);

        return redirect()->route('indexOutboundItems')->with('success', 'Data stok berhasil diubah.');
    }

    public function pdfOutboundItems()
    {
        $data = Stock::join('md_goods', 'md_goods.id_mdgoods', '=', 'stocks.item_code')
            ->join('md_units', 'md_units.id_mdunit', '=', 'stocks.unit')
            ->join('md_suppliers', 'md_suppliers.id_mdsupplier', '=', 'stocks.supplier_code')
            ->select('stocks.*', 'md_goods.code_mdgoods', 'md_units.name_mdunit', 'md_suppliers.code_mdsupplier')
            ->where('type', 'outbound')->get();
        $totalData = $data->count();
        $pdf = PDF::loadView('dashboard.feature.reports.outbound_report_pdf', compact('data', 'totalData'));
        return $pdf->download('laporan-barang-keluar.pdf');
    }
}
