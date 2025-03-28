<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width:device-width, initial-scale=1.0">
    <title>Sepet Onay</title>
    @vite(['resources/css/style.css'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="{{ asset('storage/images/flo-logo-Photoroom.png') }}" type="image/png">
</head>
<body> 

@include('layouts.header')   
<div class="container mt-5">
@if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="row"> 
        @if(isset($cartItems) && (is_array($cartItems) ? count($cartItems) > 0 : $cartItems->count() > 0))
            

            <div class="col-md-4">
                <form action="{{ route('sepet.approvl') }}" method="POST">
                    @csrf
                    <h5>Müşteri Bilgileri</h5>
                    <div class="mb-3">
                        <label for="adSoyad" class="form-label">Ad Soyad</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="adres" class="form-label">Adres</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <h5>Ödeme Bilgileri</h5>
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Kart Numarası</label>
                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="expiryDate" class="form-label">Son Kullanma Tarihi</label>
                        <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" required>
                    </div>
                    <div class="mb-3">
                        <label for="cardHolderName" class="form-label">Kart Sahibi</label>
                        <input type="text" class="form-control" id="cardHolderName" name="cardHolderName" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Siparişi Tamamla</button>
                    </div>
                </form>
            </div>
        @else
            <p class="text-center text-muted">Sepette ürün yok</p>
        @endif
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>