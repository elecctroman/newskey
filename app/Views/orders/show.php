<section class="bg-white shadow rounded p-6 space-y-4">
    <header>
        <h1 class="text-2xl font-semibold text-slate-800">Sipariş #<?= (int) $order['id'] ?></h1>
        <p class="text-sm text-slate-500">Durum: <span class="font-medium text-blue-600"><?= $security->e((string) $order['status']) ?></span></p>
    </header>
    <div class="grid md:grid-cols-2 gap-4 text-sm">
        <div>
            <h2 class="font-semibold text-slate-700 mb-2">Sipariş Detayları</h2>
            <ul class="space-y-1">
                <li>Ürün ID: <?= (int) $order['product_id'] ?></li>
                <li>Adet: <?= (int) $order['quantity'] ?></li>
                <li>Toplam: <?= number_format((float) $order['total_amount'], 2) ?> ₺</li>
            </ul>
        </div>
        <div>
            <h2 class="font-semibold text-slate-700 mb-2">Ödeme Bilgisi</h2>
            <p>Ödeme Yöntemi: <?= $security->e((string) ($order['payment_method'] ?? 'Belirtilmedi')) ?></p>
            <p>Oluşturulma: <?= $security->e((string) $order['created_at']) ?></p>
        </div>
    </div>
</section>
