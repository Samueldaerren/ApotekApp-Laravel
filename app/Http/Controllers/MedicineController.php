<?php

namespace App\Http\Controllers;
use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Exports\MedicineExport;
use Maatwebsite\Excel\Facades\Excel;


class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function exportExcel() 
     {
         return Excel::download(new MedicineExport, 'rekap-obat.xlsx');
     }
 
    
    public function index(Request $request)
    {
        $sortingmantep = $request->sorting_stock ? 'stock' : 'name';
        $medicines = Medicine::where ('name', 'LIKE' , '%' . $request->search_medicine . '%')->orderBy($sortingmantep , 'ASC') ->orderBy('name' , 'ASC')->SimplePaginate(8);
        return view('medicine.show', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     */ 
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|max:100',
            'type' => 'required|min:3',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ],
    [
        'name.required' => 'Medicine name is required and max 100 characters',
        'type.required' => 'Medicine type is required and min 3 characters',
        'price.required' => 'Medicine price is required and must be numeric',
        'stock.required' => 'Medicine stock is required and must be numeric',
    ]);

        Medicine::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock
        ]);
        return redirect()->route('medicine.show')->with('success','Medicines ' .  $request->name .  ' successfull being added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Medicine::all();
        return view('file', compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $medicine = Medicine::where('id', $id)->first();

        return view('medicine.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
        ]);

        Medicine::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
        ]);
        return redirect()->route('medicine.show')->with('success','Medicines ' .  ' succesfull being update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $deleteData = Medicine::where('id', $id)->delete();
        if($deleteData){
            return redirect()->back()->with('success', 'Medicine ' . ' Already be deleted');
        } else {
            return redirect()->back()->with('error', 'Medicine ' .       ' Eror deleting');
        }
    }

    public function updateStock(Request $request, $id){
    if (!isset($request->stock) || $request->stock == 0) {
        $BeforeStocks = Medicine::where('id', $id)->first();

        return redirect()->back()->with([
            'Failed' => $request->stock == 0
                ? 'Stock cannot be 0.'  // Jika stock bernilai 0, kirim pesan ini
                : 'Medicine stock cannot be empty.',  // Jika stock kosong, kirim pesan ini

            'id' => $id,
            'stock' => $BeforeStocks->stock ,
        ]);
    }
            Medicine::where('id' , $id )->update([
                'stock' => $request->stock
            ]);
            return redirect()->back()->with('success', 'Medicine stock updated successfully');
    }
}
