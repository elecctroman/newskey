<section class="max-w-lg bg-white shadow rounded p-6 space-y-4">
    <h1 class="text-2xl font-semibold text-slate-800">Tedarikçi API Anahtarları</h1>
    <p class="text-sm text-slate-500">Anahtarlar AES-256 ile şifrelenerek veritabanında saklanır.</p>
    <form method="POST" action="/admin/api-keys" class="space-y-3">
        <input type="hidden" name="_token" value="<?= $security->csrfToken() ?>">
        <div>
            <label class="block text-sm font-medium text-slate-600">Tedarikçi</label>
            <select name="supplier" class="mt-1 w-full border border-slate-200 rounded px-3 py-2" required>
                <option value="turkpin">TurkPin</option>
                <option value="pinabi">PinAbi</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600">API Key</label>
            <input type="text" name="api_key" class="mt-1 w-full border border-slate-200 rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600">API Secret</label>
            <input type="text" name="api_secret" class="mt-1 w-full border border-slate-200 rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Kaydet</button>
    </form>
</section>
