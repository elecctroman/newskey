<article class="bg-white shadow rounded p-6 space-y-4">
    <header>
        <h1 class="text-3xl font-semibold text-slate-800"><?= $security->e($product['title']) ?></h1>
        <p class="text-sm text-slate-500 mt-1">
            <?= number_format((float) $product['price'], 2) ?> ₺ • <?= $security->e((string) $product['type']) ?>
        </p>
    </header>
    <section class="prose max-w-none">
        <?= nl2br($security->e((string) ($product['description'] ?? ''))) ?>
    </section>
    <form method="POST" action="/orders" class="space-y-2">
        <input type="hidden" name="_token" value="<?= $security->csrfToken() ?>">
        <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
        <label class="block text-sm font-medium text-slate-600">Adet</label>
        <input type="number" name="quantity" value="1" min="1" class="w-24 border border-slate-200 rounded px-3 py-2">
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded">Satın Al</button>
    </form>
</article>
