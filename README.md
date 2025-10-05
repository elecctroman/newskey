# NewsKey Dijital Ürün Platformu

Profesyonel e-pin, lisans anahtarı ve dijital hesap satışlarını yönetmek için PHP 8.2 ve MySQL üzerinde manuel MVC mimarisi ile geliştirilmiş bir uygulama.

## Başlangıç


   ```

## Klasör Yapısı

- `core/` – Router, Controller, Model, View gibi çekirdek sınıflar.
- `app/Controllers/` – Auth, Product, Order, Payment, Admin, Ticket denetleyicileri.
- `app/Models/` – Kullanıcı, ürün, sipariş, ödeme vb. modeller.
- `app/Services/` – Ödeme ve tedarikçi API servisleri, JobQueue, NetGSM.
- `app/Views/` – TailwindCSS tabanlı arayüz şablonları.
- `database/` – SQL migration dosyaları ve demo seeder.
- `docs/` – API dokümantasyonu.


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
