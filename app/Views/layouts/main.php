<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $security->e($title) . ' | ' : '' ?>NewsKey</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.3/dist/tailwind.min.css">
</head>
<body class="bg-slate-100 min-h-screen">
    <header class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-blue-600">NewsKey</a>
            <nav class="space-x-4 text-sm">
                <a href="/products" class="text-slate-600 hover:text-blue-600">Ürünler</a>
                <a href="/blog" class="text-slate-600 hover:text-blue-600">Blog</a>
                <a href="/tickets" class="text-slate-600 hover:text-blue-600">Destek</a>
            </nav>
        </div>
    </header>
    <main class="max-w-6xl mx-auto px-4 py-8">
        <?= $content ?? '' ?>
    </main>
    <footer class="bg-slate-900 text-slate-200 text-center py-6 text-sm">
        &copy; <?= date('Y') ?> NewsKey Dijital Platformu
    </footer>
</body>
</html>
