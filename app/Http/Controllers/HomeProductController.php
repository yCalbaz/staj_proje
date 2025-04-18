<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HomeProductController extends Controller 
{ 

    public function productHome()
    {
         
        $products = Product::orderBy('id', 'desc')->get()->filter(function($product) {
            try {
                $response = Http::timeout(4)->get("http://host.docker.internal:3000/stock/{$product->product_sku}");
                
                if ($response->successful()) {
                    $stockData = $response->json();
                    $stock = $stockData['stores'][0]['stock'] ?? 0; 
                    return $stock > 0;
                }
            } catch (\Exception $e) {
                
            }
            return false;
        })->take(4);
    
        return view('home', compact('products'));
    }
    public function index()
    {
        $categories = Category::all();
        return view('product_panel', compact('categories'));
    } 

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_sku' => 'required|string|unique:products,product_sku',
            'product_price' => 'required|numeric|min:0|max:9999999',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_ids' => 'required|array|exists:categories,id',
            'details'=>'required',
        ]);

        if(Auth::check()){
            $customer_id =Auth::id();
        }else{
            return redirect()->back()->withErrors(['error'=>'Ürün eklemek için oturum açın']);
        }

        $image = $request->file('product_image');
        $imagePath = $image->store('images');
        $imageUrl = Storage::url($imagePath);


        $product = new Product;
        $product->product_name = $request->product_name;
        $product->product_sku = $request->product_sku;
        $product->product_price = $request->product_price;
        $product->product_image = $imageUrl;
        $product->details= $request->details;
        $product->customer_id= $customer_id;
        $product->save();

        if ($request->category_ids) {
            $product->categories()->attach($request->category_ids);
        }

        $productCategories = $product->categories()->pluck('category_name')->toArray();

        return redirect()->route('product.index.form')
            ->with('success', 'Ürün başarıyla eklendi.')
            ->with('product_categories', $productCategories);  

    }

    
}
