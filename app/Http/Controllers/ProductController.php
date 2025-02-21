<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function create()
    {
        return view('urun_panel'); // Sayfa adı farklıysa düzelt
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_sku' => 'required|string|unique:products,product_sku',
            'product_price' => 'required|numeric|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('product_images', 'public');
        }

        Product::create([
            'product_name' => $request->product_name,
            'product_sku' => $request->product_sku,
            'product_price' => $request->product_price,
            'product_image' => $imagePath,
        ]);

        return redirect()->route('products.create')->with('success', 'Ürün başarıyla eklendi.');
    }
}
