<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{

    public function exportExcel() 
    {
        return Excel::download(new OrderExport, 'rekap-pembelian.xlsx');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $searchDate = $request->input('search_order');  // Get search date from input

    // Build query based on user and filter date if provided
    $query = Order::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC');

    if ($searchDate) {
        // Filter orders by the input date
        $query->whereDate('created_at', '=', $searchDate);
    }

    // Paginate the results after applying the date filter
    $orders = $query->simplePaginate(5);

    return view('order.kasir.kasir', compact('orders'));
    }

    public function indexAdmin(Request $request) 
    {
        $searchDate = $request->input('search_order');  // Get search date from input

    // Build query based on user and filter date if provided
    $query = Order::with('user')->orderBy('created_at', 'DESC');

    if ($searchDate) {
        // Filter orders by the input date
        $query->whereDate('created_at', '=', $searchDate);
    }

    // Paginate the results after applying the date filter
    $orders = $query->simplePaginate(5);

    return view('order.admin.data', compact('orders'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi data request
        $request->validate([
            "name_customer" => "required",
            "medicines" => "required"
        ]);

        //mencari values array yang datanya sama
        $arrayValues = array_count_values($request->medicines);
        
        //membuat array kosong untuk menampung nilai format array yang baru
        $arrayNewMedicines = [];
        //looping array data duplikat 
        foreach ($arrayValues as $key => $value) {
            //mencari data obar berdasarkan id yang dipilih
            $medicine = Medicine::where('id', $key)->first();

            if($medicine['stock'] < $value) {
                $valueBefore = [
                "name_customer" => $request->name_customer,
                "medicines" => $request->medicines
                ];
                $msg = 'Stok Obat ' . $medicine['name'] . ' Tidak Cukup';
                return redirect()->back()->withInput()->with(['failed' => $msg, "valueBefore" => $valueBefore]);
            } else {
                $medicine['stock'] -= $value;
                $medicine->save();
            }
            //untuk mntotalkan harga medicine
            $totalPrice = $medicine['price'] * $value;
            //format array baru
            $arrayItem = [
                "id" => $key,
                "name_medicine" => $medicine['name'],
                "qty" => $value,
                "price" => $medicine['price'],
                "total_price" => $totalPrice
            ];

            array_push($arrayNewMedicines, $arrayItem);
        }

        //unutk menghitung total
        $total = 0;
        //looping data array dari array format baru
        foreach($arrayNewMedicines as $item) {
            //mentotal price sebelum ppn dari medicine kedalam variabel total
            $total += $item['total_price'];

            //merubah total dikali dengan ppn sebesar 10%
            $ppn = $total + ($total * 0.1);

            //tambahkan result kedalam database order
            $orders = Order::create([
                'user_id' => Auth::user()->id,
                'medicines' => $arrayNewMedicines,
                'name_customer' => $request->name_customer,
                'total_price' => $ppn
            ]);

            if($orders) {
                //jika tambah orders berhasil, ambil data order berdasarkan kasir yang sedang login (where),
                //dengan tanggal paling baru (OrderBy), ambil hanya satu data (first)
                $resutl = Order::where('user_id', Auth::user()->id)->orderBy
                ('created_at', 'DESC')->first();
                return redirect()->route('pembelian.print', $resutl['id'])->with('success', "Berhasil Order");
            } else {
                return redirect()->back()->with('failed', "Gagal Order");
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order, $id)
    {
        $order = Order::where('id', $id)->first();
        return view('order.kasir.print', compact('order'));     
    }

    public function create()
    {
        // Ambil data obat dari database
        $medicines = Medicine::all(); // Ambil semua data obat

        // Kirim data ke view
        return view('order.form', compact('medicines'));
    }

    public function downloadPDF($id) 
    {     
        $order = Order::where('id', $id)->first()->toArray();
        
        //buat nama variabel yang akan digunakan di pdf
        view()->share('order', $order);

        //panggil file yang akan diubah menjadi pdf
        $pdf = Pdf::loadView('order.kasir.pdf', $order);
        
        return $pdf->download('struk-pembelian.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
