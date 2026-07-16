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

        <div class="journal-spread" id="journalSpread" data-page="<?= $page ?>">

            <button class="page-corner page-corner-prev <?= $page <= 1 ? 'hidden' : '' ?>"
                    id="btnPrev" title="Página anterior">
                <span class="corner-icon">&#9664;</span>
            </button>

            <div id="gridContainer">
                <?= $this->render('partials/cells', ['page' => $page, 'start' => $start, 'end' => $end]) ?>
            </div>

            <!-- Hoja que gira durante la animación -->
            <div class="page-flip" id="pageFlip"></div>

            <button class="page-corner page-corner-next" id="btnNext" title="Siguiente página">
                <span class="corner-icon">&#9654;</span>
            </button>

        </div>

        <div class="page-indicator" id="pageIndicator">
            <span><?= $start ?> - <?= $end ?></span>
        </div>
        
    </main>

    <script>
    (function() {
        var spread = document.getElementById('journalSpread');
        var container = document.getElementById('gridContainer');
        var indicator = document.getElementById('pageIndicator');
        var btnPrev = document.getElementById('btnPrev');
        var btnNext = document.getElementById('btnNext');
        var flip = document.getElementById('pageFlip');
        var currentPage = parseInt(spread.dataset.page);
        var loading = false;
        var baseUrl = '<?= base_url('api/cells/') ?>';

        function loadPage(newPage, direction) {
            if (loading) return;
            loading = true;

            // Deshabilitar botones
            btnPrev.disabled = true;
            btnNext.disabled = true;

            // Posicionar la hoja que gira
            flip.className = 'page-flip';

            if (direction === 'next') {
                // Gira desde la derecha hacia la izquierda (eje = lomo)
                flip.style.left = '50%';
                flip.style.right = '0';
                flip.style.top = '0';
                flip.style.bottom = '0';
                flip.style.transformOrigin = 'left center';

                // Forzar reflow, luego activar animación
                void flip.offsetWidth;
                flip.classList.add('flipping-next');

            } else {
                // Gira desde la izquierda hacia la derecha (eje = lomo)
                flip.style.left = '0';
                flip.style.right = '50%';
                flip.style.top = '0';
                flip.style.bottom = '0';
                flip.style.transformOrigin = 'right center';

                void flip.offsetWidth;
                flip.classList.add('flipping-prev');
            }

            // A mitad de la animación (cuando la hoja está vertical), cambiar contenido
            setTimeout(function() {
                fetch(baseUrl + newPage)
                    .then(function(r) { return r.text(); })
                    .then(function(html) {
                        container.innerHTML = html;
                        currentPage = newPage;
                        spread.dataset.page = currentPage;

                        var start = (currentPage - 1) * 50 + 1;
                        var end = start + 49;
                        indicator.innerHTML = '<span>' + start + ' - ' + end + '</span>';
                        btnPrev.classList.toggle('hidden', currentPage <= 1);
                    })
                    .catch(function() {
                        flip.className = 'page-flip';
                        loading = false;
                        btnPrev.disabled = false;
                        btnNext.disabled = false;
                    });
            }, 450);

            // Al terminar la animación, limpiar
            setTimeout(function() {
                flip.className = 'page-flip';
                loading = false;
                btnPrev.disabled = false;
                btnNext.disabled = false;
            }, 900);
        }

        btnPrev.addEventListener('click', function() {
            if (currentPage > 1) loadPage(currentPage - 1, 'prev');
        });

        btnNext.addEventListener('click', function() {
            loadPage(currentPage + 1, 'next');
        });

    })();
    </script>

</body>
</html>
