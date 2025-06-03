<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{    public function index()
    {
        $productImages = ProductImage::with('product')->paginate(16);
        $products = Product::all();
        return view('product_images.index', compact('productImages', 'products'));
    }

    public function create()
    {
        $products = Product::all();
        return view('product_images.create', compact('products'));
    }    public function show($id)
    {
        $productImage = ProductImage::with(['product', 'product.images'])->findOrFail($id);
        $otherImages = ProductImage::where('product_id', $productImage->product_id)
                                   ->where('id', '!=', $productImage->id)
                                   ->orderBy('sort_order')
                                   ->orderBy('is_primary', 'desc')
                                   ->get();
        return view('product_images.show', compact('productImage', 'otherImages'));
    }public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'image_url' => 'nullable|url',
            'alt_text' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Handle file upload if provided
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('product_images', $fileName, 'public');
            $data['image_url'] = asset('storage/' . $filePath);
        }

        $image = ProductImage::create($data);
        return redirect()->route('product-images.index')->with('success', 'Product image created successfully');
    }

    public function edit($id)
    {
        $productImage = ProductImage::findOrFail($id);
        $products = Product::all();
        return view('product_images.edit', compact('productImage', 'products'));
    }    public function update(Request $request, $id)
    {
        $image = ProductImage::findOrFail($id);
        $data = $request->validate([
            'product_id' => 'sometimes|required|exists:products,id',
            'image_url' => 'nullable|url',
            'alt_text' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Handle file upload if provided
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('product_images', $fileName, 'public');
            $data['image_url'] = asset('storage/' . $filePath);
        }

        $image->update($data);
        return redirect()->route('product-images.index')->with('success', 'Product image updated successfully');
    }

    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);
        $image->delete();
        return redirect()->route('product-images.index')->with('success', 'Imagen de producto eliminada exitosamente');
    }
}
