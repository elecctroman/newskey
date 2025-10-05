<section class="max-w-md mx-auto bg-white shadow rounded p-6 space-y-4">
    <h1 class="text-2xl font-semibold text-slate-800">Giriş Yap</h1>
    <form method="POST" action="/login" class="space-y-4">
        <input type="hidden" name="_token" value="<?= $security->csrfToken() ?>">
        <div>
            <label class="block text-sm font-medium text-slate-600">E-posta</label>
            <input type="email" name="email" class="mt-1 w-full border border-slate-200 rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-600">Şifre</label>
            <input type="password" name="password" class="mt-1 w-full border border-slate-200 rounded px-3 py-2" required>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Giriş Yap</button>
    </form>
    <p class="text-sm text-slate-500 text-center">
        <a href="/forgot-password" class="text-blue-600 hover:underline">Şifremi unuttum</a>
    </p>
</section>
