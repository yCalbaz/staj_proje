<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sayfa Başlığı</title>
    <link rel="icon" href="{{ asset('storage/images/flo-logo-Photoroom.png') }}" type="image/png" >
  
</head>
<body>

<nav class="category-menu">
<div class="container">
</div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light custom-header">
    <div class="container d-flex align-items-center">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('storage/images/flo-logo-Photoroom.png') }}" alt="" height="50">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <form class="search-form" id="searchForm" action="{{ route('search') }}" method="GET">
                <input class="search-input" type="search" name="query" placeholder="Ara" aria-label="Ara">
            </form>
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.logout') }}"> Çıkış Yap</a></li>
                @endauth
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"> Giriş Yap</a></li>
                @endguest
                <li class="nav-item"><a class="nav-link" href="{{ route('sepet.index') }}">
                        Sepetim
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-dark">
                            {{ $sepetSayisi ?? 0 }}
                        </span>
                    </a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Siparişlerim</a></li>
            </ul>
        </div>
    </div>
</nav>

<nav class="category-menu">
    <div class="container">
    <div class="filter-container">
    <div class="filter-dropdown">
        <button class="filter-button">Kadın <span class="arrow">▼</span></button>
        <div class="filter-options ">
            <li><a class="category" href="{{ route('category.product', ['category_slug' => 'kadın-çanta']) }}">Kadın Çanta</a></li>
            <li><a class="category" href="{{ route('category.product', ['category_slug' => 'kadın-ayakkabı']) }}">Kadın Ayakkkabı</a></li>
            <li><a class="category" href="{{ route('category.product', ['category_slug' => 'kadın-giyim']) }}">Kadın Giyim</a></li>
            <li><a class="category" href="{{ route('category.product', ['category_slug' => 'günlük-ayakkabı']) }}">Günlük Ayakkabı</a></li>
            <li><a class="category" href="{{ route('category.product', ['category_slug' => 'ayakkabı']) }}">Spor Ayakkabı</a></li>
            <li><a class="category" href="{{ route('category.product', ['category_slug' => 'bot']) }}">Bot</a></li>
            <li><a class="category" href="{{ route('category.product', ['category_slug' => 'giyim']) }}">Tişört</a></li>
            <li><a class="category" href="{{ route('category.product', ['category_slug' => 'ayakkabı']) }}">Eşofman</a></li>
         </div>
    </div>
    <div class="filter-dropdown">
        <button class="filter-button">Erkek <span class="arrow">▼</span></button>
        <div class="filter-options">
        <li><a class="category" href="{{ route('category.product', ['category_slug' => 'erkek-ayakkabı']) }}">Erkek Ayakkkabı</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'erkek-giyim']) }}">Erkek Giyim</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'günlük-ayakkabı']) }}">Günlük Ayakkabı</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'ayakkabı']) }}">Spor Ayakkabı</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'canta']) }}">Bot</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'giyim']) }}">Tişört</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'ayakkabı']) }}">Eşofman</a></li>
        </div>
    </div>
    <div class="filter-dropdown">
        <button class="filter-button">Çocuk <span class="arrow">▼</span></button>
        <div class="filter-options ">
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'çocuk-ayakkabi']) }}">Çocuk Ayakkkabı</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'çocuk-giyim']) }}">Çocuk Giyim</a></li>
        <li><a class="category" href="{{ route('category.product', ['category_slug' => 'günlük-ayakkabı']) }}">Günlük Ayakkabı</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'ayakkabı']) }}">Spor Ayakkabı</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'canta']) }}">Bot</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'giyim']) }}">Tişört</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'ayakkabı']) }}">Eşofman</a></li>
         </div>
    </div>
    <div class="filter-dropdown">
        <button class="filter-button">Marka <span class="arrow">▼</span></button>
        <div class="filter-options">
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'nike']) }}">Nike</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'adidas']) }}">Adidas</a></li>
        <li> <a class="category" href="{{ route('category.product', ['category_slug' => 'lumberjack']) }}">Lumberjack</a></li>
            
        </div>
    </div>
    
    
    </div>
</nav>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        if (!this.querySelector('input[name="query"]').value) {
            event.preventDefault();
        }
    });

    function updateCartCount(count) {
        document.getElementById('sepet-sayisi').textContent = count;
    }
    

</script>

</body>
</html>
