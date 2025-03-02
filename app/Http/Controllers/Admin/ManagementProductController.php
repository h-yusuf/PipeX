<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ManagementProductController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('product_management'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $data = ProductModel::orderBy('updated_at', 'desc')->get();
        return view('pages.product.index', compact('data'));
    }
    public function store(Request $request)
    {
        try {
            $randomNumber = str_pad(mt_rand(1000, 9999), 4, '0', STR_PAD_LEFT); 
            $productNumber = 'PN-' . now()->format('YmdHis') . $randomNumber;
    
            $request->merge(['product_number' => $productNumber]);

            $request->validate([
                'product_number' => 'required|string|max:255',
                'product_name' => 'required|string|max:255',
                'material' => 'nullable|string',
                'description' => 'nullable|string',
                'unit' => 'required|string|max:50',
                'price' => 'required|numeric|min:0',
                'status' => 'required|boolean',
            ]);

            ProductModel::create($request->all());

            return redirect()->back()->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to add product: ' . $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // dd($request->all());
            $request->validate([
                'product_name' => 'required|string|max:255',
                'material' => 'nullable|string',
                'description' => 'nullable|string',
                'unit' => 'required|string|max:50',
                'price' => 'required|numeric|min:0',
                'status' => 'required|boolean',
            ]);

            $product = ProductModel::findOrFail($id);

            $product->update($request->all());
            return redirect()->back()->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $product = ProductModel::findOrFail($id);
        return response()->json($product);
    }


    public function destroy($id)
    {
        abort_if(Gate::denies('product_management'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $product = ProductModel::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

}
