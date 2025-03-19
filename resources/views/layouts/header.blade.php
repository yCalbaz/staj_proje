<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sayfa Başlığı</title>
    <link rel="icon" href="{{ asset('storage/images/flo-logo-Photoroom.png') }}" type="image/png">
</head>
<body>



<nav class="navbar navbar-expand-lg navbar-light custom-header">
    <div class="container d-flex align-items-center">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('storage/images/flo-logo-Photoroom.png') }}" alt="" height="50">
        </a>
        
        <form class="search-form" id="searchForm" action="{{ route('search') }}" method="GET">
            <input class="search-input" type="search" name="query" placeholder="Ara" aria-label="Ara">
        </form>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{route('login')}}"><i class="fas fa-user"></i> Giriş Yap</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('sepet.index')}}"><i class="fas fa-shopping-cart"></i> Sepetim</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('orders.index')}}"><i class="fas fa-shopping-cart"></i>Siparişlerim</a></li>
        </ul>
    </div>
    
</nav>

<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        if (!this.querySelector('input[name="query"]').value) {
            event.preventDefault();
        }
    });
</script>

</body>
</html>
