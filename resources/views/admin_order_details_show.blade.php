<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Detayları (Admin)</title>
    @vite(['resources/js/app.js', 'resources/css/style.css'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table td {
            font-size: 14px;
        }

        .order_image {
            max-width: 100px;
            height: auto;
        }

        @media (max-width: 768px) {
            .table td {
                font-size: 12px;
                padding: 3px;
            }

            .order_image {
                max-width: 80px;
            }
        }
    </style>
</head>
<body>

@include('layouts.panel_header')

<div class="container mt-5">
    <div class="card mb-3">
        <div class="card-header">
        </div>
        <div class="card-body">
        
            <p><strong>Müşteri Adı:</strong> {{ $order->customer_name }}</p>
            <p><strong>Adres:</strong> {{ $order->customer_address }}</p>
            <p><strong>Tarih:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
            <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ürün Resmi</th>
                        <th>Ürün Adı</th>
                        <th>Adet</th>
                        <th>Fiyat</th>
                        <th>Mağaza</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupedOrderLines as $line)
                        <tr>
                            <td>
                                @if($line->product && $line->product->product_image)
                                    <a href="{{ route('product.details', ['sku' => $line->product->product_sku]) }}">
                                        <img src="{{ asset($line->product->product_image) }}" class="order_image">
                                    </a>
                                @else
                                    Resim Yok
                                @endif
                            </td>
                            <td>{{ $line->product->product_name }} - Beden: {{ $line->product_size }}</td>
                            <td>{{ $line->product_piece }}</td>
                            <td>{{ $line->product->product_price }}</td>
                            <td>{{ $line->store->store_name }}</td>
                            <td>{{ $line->order_status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

</body>
</html>