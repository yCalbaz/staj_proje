<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width:device-width, initial-scale=1.0">
    <title>Sipariş Detayları</title>
    @vite(['resources/js/app.js', 'resources/css/style.css'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
</head>
<body>

@include('layouts.header')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            @php
                $groupedOrderLines = $order->orderLines->groupBy('store_id');
            @endphp

            @foreach ($groupedOrderLines as $storeId => $lines)
                <div class="card mb-3">
                    <div class="card-header">
                        Satıcı: {{ $lines->first()->store->store_name ?? 'Satıcı Bilgisi Bulunamadı' }}
                        <span style="margin: 0 20px">
                            <button class="iptalEtBtnClass custom-details-button" data-id="{{ $order->order_id }}" data-store-id="{{ $storeId }}">
                                İade Et
                            </button>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ürün Resmi</th>
                                    <th>Ürün Adı</th>
                                    <th>Beden</th>
                                    <th>Adet</th>
                                    <th>Fiyat</th>
                                    <th>Sipariş Durumu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $groupedProducts = $lines->groupBy(function ($item) {
                                        return $item->product_id . '-' . $item->product_size;
                                    });
                                @endphp
                                @foreach ($groupedProducts as $productKey => $productLines)
                                    @php
                                        $firstLine = $productLines->first();
                                        $quantity = $productLines->count();
                                    @endphp
                                    <tr>
                                        <td>
                                            @if($firstLine->product)
                                                <a href="{{ route('product.details', ['sku' => $firstLine->product->product_sku]) }}">
                                                    <img src="{{ asset($firstLine->product->product_image) }}" class="order_image">
                                                </a>
                                            @else
                                                Ürün Bulunamadı.
                                            @endif
                                        </td>
                                        <td>{{ $firstLine->product_name }}</td>
                                        <td>{{ $firstLine->product_size }}</td>
                                        <td>{{ $quantity }}</td>
                                        <td>
                                            @if($firstLine->product)
                                                {{ $firstLine->product->product_price }}TL
                                            @else
                                                Ürün Bulunamadı.
                                            @endif
                                        </td>
                                        <td>{{ $firstLine->order_status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Sipariş Takibi
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach ($allOrderStatuses as $status)
                            @php
                                $isActive = false;
                                foreach ($orderStatusHistory as $historyStatus) {
                                    if ($status == $historyStatus) {
                                        $isActive = true;
                                        break;
                                    }
                                }
                            @endphp
                            <div class="timeline-item {{ $isActive ? 'active' : '' }}">
                                <div class="timeline-text">
                                    {{ $status }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    Teslimat Adresi <br>
                    
                </div>
                <div >
                <p> {{ $order->customer_address }} TL</p>
            </div></div>

           
        </div>
    </div>
</div>

@include('layouts.footer')

<script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>