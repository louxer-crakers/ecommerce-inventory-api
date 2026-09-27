<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();

        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0'
        ]);

        $product->update($validated);

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $productName = $product->name;

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => "Product '{$productName}' has been successfully deleted"
        ], 200);
    }

    public function search(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->has('name')) {
            $keyword = $request->query('name');
            $query->where('name', 'like', "%{$keyword}%");
        }
        
        if ($request->has('category_id')) {
            $categoryId = $request->query('category_id');
            $query->where('category_id', $categoryId);
        }

        $products = $query->get();

        return response()->json($products, 200);
    }

    public function updateStock(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_sold' => 'required|integer|min:1'
        ]);

        $product = Product::find($validated['product_id']);
        
        if ($product->stock_quantity < $validated['quantity_sold']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stock not enough for this transaction'
            ], 400);
        }

        $product->stock_quantity -= $validated['quantity_sold'];
        $product->save();

        return response()->json([
            'status' => 'success',
            'message' => "Stock updated successfully",
            'data' => $product
        ], 200);
    }

    public function inventoryValue(Request $request)
    {
        $totalValue = Product::selectRaw('SUM(price * stock_quantity) as total')->value('total');

        return response()->json([
            'total_inventory_value' => (float) ($totalValue ?? 0)
        ], 200);
    }
}
