# NewsKey API Dokümantasyonu

## Kimlik Doğrulama

### POST /login
- Açıklama: Kullanıcı giriş işlemi.
- Parametreler:
  - `email` (string)
  - `password` (string)
- Dönen: Başarılıysa yönlendirme, aksi halde hata mesajı.

### POST /register
- Açıklama: Yeni kullanıcı kaydı.
- Parametreler: `name`, `email`, `password`.

### POST /forgot-password
- Açıklama: Şifre sıfırlama bağlantısı gönderir.
- Parametreler: `email`, `_token`.

## Siparişler

### POST /orders
- Açıklama: Sepetteki ürün için sipariş oluşturur.
- Parametreler:
  - `product_id` (int)
  - `quantity` (int, varsayılan 1)
  - CSRF token `_token`

### GET /orders/{id}
- Açıklama: Belirli siparişi döndürür.

### GET /orders/{id}/retry
- Açıklama: Hatalı siparişi tedarikçiye yeniden iletir.

## Ödemeler Webhook

### POST /payments/shopier
- Açıklama: Shopier ödeme sonucunu karşılar.
- Güvenlik: HMAC SHA-256 `hash` kontrolü.

### POST /payments/iyzico
- Açıklama: İyzico webhook isteğini işler.

### POST /payments/paytr
- Açıklama: PayTR hash doğrulaması yaparak ödeme bildirimi alır.

## Destek Talepleri

### GET /tickets
- Açıklama: Kullanıcıya ait destek taleplerini listeler.

### POST /tickets
- Açıklama: Yeni destek talebi oluşturur.
- Parametreler: `subject`, `message`, `_token`.

## Yönetici

### GET /admin
- Açıklama: Yönetici paneli ana sayfası.

### GET /admin/orders
- Açıklama: Tüm siparişleri listeler.

### GET /admin/api-keys
- Açıklama: Tedarikçi API anahtarı formunu gösterir.

### POST /admin/api-keys
- Açıklama: Tedarikçi API anahtarlarını güvenle kaydeder.
- Parametreler: `supplier`, `api_key`, `api_secret`, `_token`.
