<section class="space-y-6">
    <header>
        <h1 class="text-3xl font-semibold text-slate-800">Siparişler</h1>
        <p class="text-slate-500 text-sm">Tüm siparişler ve durumları.</p>
    </header>
    <div class="bg-white shadow rounded overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-100 text-left">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Kullanıcı</th>
                    <th class="px-4 py-2">Ürün</th>
                    <th class="px-4 py-2">Durum</th>
                    <th class="px-4 py-2">Toplam</th>
                    <th class="px-4 py-2">İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr class="border-t">
                        <td class="px-4 py-2">#<?= (int) $order['id'] ?></td>
                        <td class="px-4 py-2"><?= (int) $order['user_id'] ?></td>
                        <td class="px-4 py-2"><?= (int) $order['product_id'] ?></td>
                        <td class="px-4 py-2 text-blue-600"><?= $security->e((string) $order['status']) ?></td>
                        <td class="px-4 py-2"><?= number_format((float) $order['total_amount'], 2) ?> ₺</td>
                        <td class="px-4 py-2">
                            <a href="/orders/<?= (int) $order['id'] ?>" class="text-blue-600 hover:underline">Görüntüle</a>
                            <a href="/orders/<?= (int) $order['id'] ?>/retry" class="ml-3 text-amber-600 hover:underline">Yeniden Dene</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
