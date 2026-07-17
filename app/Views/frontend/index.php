<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'StampCollab' ?></title>
    <link rel="shortcut icon" type="image/webp" href="/assets/logo/stampcollab.webp">

    <!-- Bulma CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/journal.css') ?>">

</head>
<body>

    <header class="site-header">
        <div class="header-content">
            <a href="<?= base_url() ?>" class="logo-link">
                <img src="<?= base_url('public/assets/logo/stampcollab.webp') ?>" alt="StampCollab" class="logo-img">
            </a>
            <nav class="header-nav">
                <a href="#" class="nav-link nav-about">about</a>
                <a href="#" class="nav-link nav-journals">journals</a>
            </nav>
        </div>
    </header>

    <main class="journal-container">

        <div class="journal-spread" id="journalSpread" data-page="1">

            <button class="page-corner page-corner-prev hidden"
                    id="btnPrev" title="Página anterior">
                <span class="corner-icon">&#9664;</span>
            </button>

            <div id="gridContainer"></div>

            <!-- Hoja que gira durante la animación -->
            <div class="page-flip" id="pageFlip"></div>

            <button class="page-corner page-corner-next" id="btnNext" title="Siguiente página">
                <span class="corner-icon">&#9654;</span>
            </button>

        </div>

        <div class="page-indicator" id="pageIndicator">
            <span></span>
        </div>
        
    </main>

    <script src="<?= base_url('public/assets/js/journal.js') ?>"></script>

</body>
</html>
