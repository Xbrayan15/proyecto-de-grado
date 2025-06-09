<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier', 'images'])->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show public catalog view
     */
    public function catalog()
    {
        $products = Product::with(['category', 'supplier'])
            ->where('active', true)
            ->paginate(12);
        
        $categories = Category::whereHas('products', function ($query) {
            $query->where('active', true);
        })->get();
        
        return view('products.catalog', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'supplier', 'images'])->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|string',
            'active' => 'boolean',
        ]);
        $product = Product::create($data);
        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'code' => 'sometimes|required|string|unique:products,code,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'quantity' => 'sometimes|required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|string',
            'active' => 'boolean',
        ]);
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente');
    }
}
