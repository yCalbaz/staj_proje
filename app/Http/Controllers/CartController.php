<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderBatch;
use App\Models\OrderLine;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::all();
        return view('sepet', compact('cartItems'));
    }

    public function add(Request $request, Product $product)
    {
        $response = Http::get("http://host.docker.internal:3000/stock/{$product->product_sku}");

        if ($response->failed()) {
            return redirect()->back()->with('error', 'Yeterli stok bulunmamaktadır.');
        }

        $stockData = $response->json();

        if (!isset($stockData['stores'])) {
            return redirect()->back()->with('error', 'Yeterli stok bulunmamaktadır.');
        }

        $totalStock = 0;
        foreach ($stockData['stores'] as $store) {
            $totalStock += $store['stock'];
        }

        if ($totalStock < $request->quantity) {
            return redirect()->back()->with('error', 'Yeterli stok bulunmamaktadır.');
        }

        $cartItem = Cart::where('product_sku', $product->product_sku)->first();

        if ($cartItem) {
            if ($cartItem->product_piece + $request->quantity > $totalStock) {
                return redirect()->back()->with('error', 'Yeterli stok bulunmamaktadır.');
            }

            $cartItem->product_piece += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'product_name' => $product->product_name,
                'product_sku' => $product->product_sku,
                'product_piece' => $request->quantity,
                'product_price' => $product->product_price,
                'product_image' => $product->product_image,
            ]);
        }

        return redirect()->back()->with('success', 'Ürün sepete eklendi');
    }

    public function delete($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Ürün sepetten kaldırıldı!');
    }

    public function approvl(Request $request)
    {
        if ($request->isMethod('post')) {
            $cartItems = Cart::all();
            $totalPrice = 0;
            $stokError = false;
            $storeId = [];

            foreach ($cartItems as $item) {
                $response = Http::get("http://host.docker.internal:3000/stock/{$item->product_sku}");

                if ($response->failed()) {
                    return redirect()->with('error', 'Stok servisine ulaşılmıyor');
                }

                $stockData = $response->json();
                if (!isset($stockData['stores'])) {
                    return redirect()->back()->with('error', 'Yeterli stok yok');
                }

                $totalStock = 0;
                foreach ($stockData['stores'] as $store) {
                    $totalStock += $store['stock'];

                    $storeId[$item->product_sku] = $store['store_id'];
                }

                if ($totalStock < $item->product_piece) {
                    $stokError = true;
                    break;
                }

                $totalPrice += ($item->product_price * $item->product_piece);
            }

            if ($stokError) {
                return redirect()->back()->with('error', 'Yeterli stok yok');
            }

            $adSoyad = $request->input('adSoyad');
            $adres = $request->input('adres');

            $orderBatch = OrderBatch::create([
                'customer_name' => $adSoyad,
                'customer_address' => $adres,
                'product_price' => $totalPrice,
            ]);

            $orderId = $orderBatch->id;
            $orderBatch->order_id = $orderId;
            $orderBatch->save();

            $groupedItems = [];
            foreach ($cartItems as $item) {
                $store = $storeId[$item->product_sku];
                if (!isset($groupedItems[$store])) {
                    $groupedItems[$store] = [];
                }
                $groupedItems[$store][] = $item;
            }

            $subOrderId = 1;
            foreach ($groupedItems as $store => $items) {
                $orderLinesData = [];
                foreach ($items as $item) {
                    for ($i = 0; $i < $item->product_piece; $i++) {
                        $orderLinesData[] = [
                            'product_sku' => $item->product_sku,
                            'product_name' => $item->product_name,
                            'store_id' => $store,
                            'order_id' => (count($groupedItems) > 1) ? $orderId . '-' . $subOrderId : $orderId,
                            'order_batch_id' => $orderId,
                        ];
                    }
                }
                try {
                    OrderLine::insert($orderLinesData);
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Sipariş oluşturulurken hata oludu.' . $e->getMessage());
                }
                $subOrderId++;
            }

            foreach ($groupedItems as $store => $items) {
                foreach ($items as $item) {
                    Log::info("Stok Güncelleme İşlemi Başlatılıyor: " . json_encode([
                        'product_sku' => $item->product_sku,
                        'product_piece' => $item->product_piece,
                        'store_id' => $store,
                    ]));

                   
                    $currentStock = DB::table('stocks')
                        ->where('product_sku', $item->product_sku)
                        ->where('store_id', $store)
                        ->value('product_piece');

                    if ($currentStock < $item->product_piece) {
                        Log::error("Stok Yetersiz! " . json_encode([
                            'product_sku' => $item->product_sku,
                            'store_id' => $store,
                            'current_stock' => $currentStock,
                            'requested_stock' => $item->product_piece,
                        ]));

                        return redirect()->back()->with('error', 'Yeterli stok bulunmamaktadır!');
                    }

                    
                    DB::table('stocks')
                        ->where('product_sku', $item->product_sku)
                        ->where('store_id', $store)
                        ->decrement('product_piece', $item->product_piece);

                    Log::info("Stok Güncellendi: " . json_encode([
                        'product_sku' => $item->product_sku,
                        'store_id' => $store,
                        'used_stock' => $item->product_piece,
                        'remaining_stock' => $currentStock - $item->product_piece
                    ]));
                }
            }

            Cart::truncate();
            return redirect()->route('sepet.approvl')->with('success', 'Sipariş onaylandı');
        }

        $cartItems = Cart::all();
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += ($item->product_price * $item->product_piece);
        }
        $data = compact('cartItems', 'totalPrice');
        return view('sepet_onay', $data);
    }
}