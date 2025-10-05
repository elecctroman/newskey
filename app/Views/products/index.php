<section class="space-y-6">
    <header class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-800">Ürünler</h1>
            <p class="text-slate-500 text-sm">E-pin, lisans ve dijital hesap kategorilerinde ürünleri keşfedin.</p>
        </div>
        <a href="/cart" class="px-4 py-2 bg-blue-600 text-white rounded">Sepeti Gör</a>
    </header>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach ($products as $product): ?>
            <article class="bg-white shadow rounded p-4 space-y-2">
                <h2 class="text-lg font-semibold text-slate-800">
                    <a href="/products/<?= $security->e($product['slug']) ?>" class="hover:text-blue-600">
                        <?= $security->e($product['title']) ?>
                    </a>
                </h2>
                <p class="text-sm text-slate-500"><?= number_format((float) $product['price'], 2) ?> ₺</p>
                <p class="text-xs text-slate-400 uppercase"><?= $security->e((string) $product['type']) ?></p>
                <form method="POST" action="/orders" class="space-y-2">
                    <input type="hidden" name="_token" value="<?= $security->csrfToken() ?>">
                    <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded">Satın Al</button>
                </form>
            </article>
        <?php endforeach; ?>
    </div>
</section>
