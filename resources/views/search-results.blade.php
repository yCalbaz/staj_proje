<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arama Sonuçları</title>
    @vite(['resources/js/app.js' ,'resources/css/style.css'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('storage/images/flo-logo-Photoroom.png') }}" type="image/png">
</head>
<body>
    @include('layouts.header')

    <div class="container mt-5">
        <h2>Arama Sonuçları: "{{ $query }}"</h2>

        @if($products->count() > 0)
            <div class="row">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4 d-flex justify-content-center">
                        <div class="card shadow-sm custom-card">
                            <img src="{{ asset($product->product_image) }}" class="card-img-top custom-img">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                <p class="card-text font-weight-bold">{{ $product->product_price }} TL</p>
                                <button type="submit" class="btn btn-primary btn-sm" onclick="addCart( '{{$product->product_sku }}')">Sepete Ekle</button>
                            <a href="{{ route('product.details', ['sku' => $product->product_sku]) }}" class="btn btn-secondary btn-sm mt-2">İncele</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Aradığınız kriterlere eşleşen ürün yok.</p>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function addCart(productSku) {
    $.ajax({
        url: "{{ route('cart.add', ':sku') }}".replace(':sku', productSku), 
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            quantity: 1
        },
        success: function (response) {
            console.log("Başarıyla eklendi:", response);
            alert("Ürün sepete eklendi!");
        },
        error: function (xhr) {
            console.log("Hata oluştu! Durum kodu:", xhr.status);
            console.log("Hata mesajı:", xhr.responseText);
            alert("Hata oluştu! " + xhr.responseText);
        }
    });
}

</script>