## Proje Hakkında
Bu proje, Laravel, Go ve Docker kullanılarak geliştirilmiş bir e-ticaret sitesidir. Kullanıcılar  sepetlerine ürün ekleyebilir, sipariş verebilirler.Ayrıca kullanıcı kendi bilgileri ile kayıt olabilir ve oturumu içinde yaptığı sepete ekleme işlemlerini ve önceki sipariş bilgilerini görebilirler.Önceden onaylanmış siparişlere iade taleb oluşturabilirler. Satıcı paneli üzerinden ürün, stok, depo yönetimi, sipariş kontrolu, kampanya ekleme ve statu değişimi yapılabilir. Admin paneli üzerinden ürün eklenebilir, stok eklenebilir, depo eklenebilir, tüm siparişler listelenebilir ve kullanıcıların yetkilendirebilir veya silebilir.

## Temel Özellikler
- Ürün ekleme, düzenleme ve silme
- Depo yönetimi ve stok takibi
- Sepet ve ödeme işlemleri
- Sipariş detaylarını görme ve iade etme seçeneği
- Admin paneli üzerinden yönetim
- Satıcı paneli üzerinden ürün yönetimi
- Depoya sipariş atama ve stoktan düşme



# Kurulum
## Gereksinimler
- PHP 8.1 veya üstü
- Laravel
- Composer
- Docker ve Docker Compose (isteğe bağlı)
- MySQL
- Go (stok kontrol servisi için)
- Ajax
- Ngnix
- [github](https://github.com/yCalbaz/Laravel_e-ticaret_sitesi)

## Proje Yapısı
- app/: Uygulamanın tüm iş mantığını barındırır.
- resources/views/: Blade şablon dosyalarını içerir.
- routes/: Laravel yönlendirme dosyaları.
- tests/: Unit testlerinin bulunduğu yer.
- go/: Go ile yazılmış stok kontrol servisi.(Ayrı bir proje dosyası olarak)

## Kullanılan Teknolojiler
- Laravel: PHP framework
- Go: Stok kontrol servisi
- MySQL: Veritabanı yönetimi
- Docker: Proje konteynerlemesi ve yönetimi
- Vite: JavaScript derleyicisi
- Html / Css : Sayfa görünüşü için
- Ajax: Uyarıları vermek ve sayfayı yenilemek için
