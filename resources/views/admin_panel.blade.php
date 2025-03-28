<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün</title>
    @vite(['resources/css/style.css'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="{{ asset('storage/images/flo-logo-Photoroom.png') }}" type="image/png">
</head>
<body> 
    

@include('layouts.panel_header')
<div class="header">
    <h1>Admin Panel</h1>

   
    <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
        @csrf
        <button type="submit" class="logout-btn" >Çıkış</button>
    </form>
</div>

<br>

<div class="container text-center">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <a href="{{ route('product.index.form') }}" class="panel-box">
                <div class="box">
                    <h2>Ürün Paneli</h2>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('store.index.form' )}}" class="panel-box">
                <div class="box">
                    <h2>Depo Paneli</h2>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('stock.index.form' )}}" class="panel-box">
                <div class="box">
                    <h2>Stok Paneli</h2>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('members.index' )}}" class="panel-box">
                <div class="box">
                    <h2>Kullanıcılar</h2>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('orders.index' )}}" class="panel-box">
                <div class="box">
                    <h2>Sipariş bilgileri</h2>
                </div>
            </a>
        </div>
   
    </div>
</div>



<style>
    h2{
        color: white;
    }
</style>
</body>
</html>
