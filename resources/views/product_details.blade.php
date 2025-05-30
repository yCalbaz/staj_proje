<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->product_name }} - Ürün Detayı</title>
    @vite(['resources/js/app.js', 'resources/css/style.css', 'resources/css/product_details.css'])
    <link rel="icon" href="{{ asset('storage/images/flo-logo-Photoroom.png') }}" type="image/png">
</head>
<body>
    @include('layouts.header')  

    <div class="container product-detail-container">
        <div class="row">
            <div class="col-md-6 product-image-container">
                <img src="{{ asset($product->product_image) }}" class="product-image" alt="{{ $product->product_name }}">
            </div>
            <div class="col-md-6 product-info">
                <h2 style="color: #333;">{{ $product->product_name }}</h2>
                @if ($discountRate > 0 && $discountedPrice !== null)
                    <p class="original-price" style=" color: red; margin-bottom:2px;">Önceki Fiyat:</p>
                    <p class="original-price" style="text-decoration: line-through; color: red;">{{ $product->product_price }} TL</p>
                    <p class="discounted-price" style="color: green; font-weight: bold; font-size:20px;">{{ number_format($discountedPrice, 2) }} TL </p>
                @else
                    <p class="product-price">{{ $product->product_price }} TL</p>
                @endif
                <details>
                    <summary style="font-size: large;" >Ürün Detayı</summary>
                    <p class="product-description">{{ $product->details }}</p>
                </details>
                <br>
                <h5>Beden Seçimi:</h5>
                <div class="size" >
                    @foreach ($groupedStocks as $stock)
                        @if ($stock['total_piece'] > 0 && $stock['size'])
                            <button data-size-id="{{ $stock['size']->id }}" class="size-button">{{ $stock['size']->size_name }}</button>
                        @elseif ($stock['size'])
                            <button class="size-button" style="text-decoration: line-through; opacity: 0.5; cursor: not-allowed;" disabled>{{ $stock['size']->size_name }}</button>
                        @endif
                    @endforeach
                </div>
                <br>

                <button type="button" class="add-to-cart-button" onclick="addCart('{{ $product->product_sku }}')">Sepete Ekle</button>
            </div>
        </div>
    </div>
    <br>
    @include('layouts.footer')
</body>
</html>