<section class="space-y-6">
    <header class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-800">Destek Taleplerim</h1>
            <p class="text-slate-500 text-sm">Yeni bir talep oluşturup mevcut taleplerinizi takip edin.</p>
        </div>
    </header>
    <form method="POST" action="/tickets" class="bg-white shadow rounded p-4 space-y-3">
        <h2 class="text-lg font-semibold text-slate-700">Yeni Talep</h2>
        <input type="hidden" name="_token" value="<?= $security->csrfToken() ?>">
        <div>
            <label class="block text-sm font-medium text-slate-600">Konu</label>
            <input type="text" name="subject" class="mt-1 w-full border border-slate-200 rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600">Mesaj</label>
            <textarea name="message" rows="4" class="mt-1 w-full border border-slate-200 rounded px-3 py-2" required></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Talep Oluştur</button>
    </form>
    <div class="bg-white shadow rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-100 text-left">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Konu</th>
                    <th class="px-4 py-2">Durum</th>
                    <th class="px-4 py-2">Tarih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $ticket): ?>
                    <tr class="border-t">
                        <td class="px-4 py-2">#<?= (int) $ticket['id'] ?></td>
                        <td class="px-4 py-2"><?= $security->e((string) $ticket['subject']) ?></td>
                        <td class="px-4 py-2 text-blue-600"><?= $security->e((string) $ticket['status']) ?></td>
                        <td class="px-4 py-2"><?= $security->e((string) $ticket['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
