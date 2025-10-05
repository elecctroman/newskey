# NewsKey Dijital Ürün Platformu

Profesyonel e-pin, lisans anahtarı ve dijital hesap satışlarını yönetmek için PHP 8.2 ve MySQL üzerinde manuel MVC mimarisi ile geliştirilmiş bir uygulama.

## Başlangıç

1. Depoyu klonlayın ve bağımlılıkları yükleyin:
   ```bash
   composer install
   cp .env.example .env
   ```
2. `.env` dosyasında veritabanı ve servis bilgilerini güncelleyin.
3. Veritabanı tablolarını oluşturun:
   ```bash
   mysql -u root -p newskey < database/migrations.sql
   ```
4. (Opsiyonel) Demo verileri yükleyin:
   ```bash
   php database/demo_seeder.php
   ```
5. Uygulamayı çalıştırmak için dahili PHP sunucusunu kullanın:
   ```bash
   php -S localhost:8000 -t public
   ```

## Klasör Yapısı

- `core/` – Router, Controller, Model, View gibi çekirdek sınıflar.
- `app/Controllers/` – Auth, Product, Order, Payment, Admin, Ticket denetleyicileri.
- `app/Models/` – Kullanıcı, ürün, sipariş, ödeme vb. modeller.
- `app/Services/` – Ödeme ve tedarikçi API servisleri, JobQueue, NetGSM.
- `app/Views/` – TailwindCSS tabanlı arayüz şablonları.
- `database/` – SQL migration dosyaları ve demo seeder.
- `docs/` – API dokümantasyonu.
- `public/` – `index.php` giriş noktası ve `htaccess` için uygun konum.

## Özellikler

- Otomatik ürün teslimatı için TurkPin ve PinAbi entegrasyonları.
- Shopier, İyzico ve PayTR ödeme servisleri için webhook ve hash doğrulama.
- Kullanıcı, cüzdan, sipariş, yorum ve blog modülleri.
- Yönetici paneli, API anahtarı saklama, yeniden deneme servisi.
- CSRF, XSS korumaları ve loglama sistemi.

## Test ve Geliştirme

- Kod standartları PSR-12 uyumlu yazılmıştır.
- TailwindCSS CDN ile hafif arayüz.
- JobQueue sınıfı ile cronjob tabanlı arka plan işleri desteklenir.

Daha fazla bilgi için `docs/api.md` dosyasına göz atın.
