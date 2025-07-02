<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function dashboard(){
        $data = Product::all();
        $produkPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $produkPerBulan[] = Product::whereMonth('created_at', $i)->count();            
        }
        return view('dashboard', compact('data', 'produkPerBulan'));
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    return '<img src="' . asset('images/' . $row->image) . '" alt="Image" style="width: 100px; height: 100px;">';
                })
                ->addColumn('action', function($row){
                    return '<button class="btn btn-primary" data-id="' . $row->id . '" data-toggle="modal" id="edit-product" data-target="#editProductModal">Edit</button>
                            <button type="button" class="btn btn-danger" id="delete-product" data-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('products.index');

    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'developer' => 'required',
            'image' => 'required|file',
        ]);
        try {
        $imageName = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validatedData['image'] = $imageName;
        }

        Product::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Produk berhasil dibuat!'], 200);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Gagal membuat produk! ' . $th->getMessage()], 500);
        }
    }

    public function getProduct(Product $product)
    {
        $data = Product::findOrFail($product->id);
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $data = Product::find($product->id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $data = Product::find($product->id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'developer' => 'required',
        ]);
        
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $validatedData['image'] = $imageName;
            }
            $product->update($validatedData);

            return response()->json(['success' => true, 'message' => 'Produk berhasil diperbarui!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui produk! ' . $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus!'], 200); 
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus produk! ' . $th->getMessage()], 500);
        }
    }

    public function exportPDF()
    {
        $data = Product::all();
        $pdf = Pdf::loadView('products.export-pdf', compact('data'));
        return $pdf->download('products.pdf');
    }
}
