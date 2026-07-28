(function () {

    var spread = document.getElementById('journalSpread');
    if (!spread) return;

    var container = document.getElementById('gridContainer');
    var indicator = document.getElementById('pageIndicator');
    var btnPrev = document.getElementById('btnPrev');
    var btnNext = document.getElementById('btnNext');
    var flip = document.getElementById('pageFlip');
    var currentPage = parseInt(spread.dataset.page);
    var journalId = parseInt(spread.dataset.journalId);
    var uploadUrl = null;
    var allowedFormats = [];
    var cropRatio = { w: 21, h: 25 };
    var perSide = 25;
    var totalPages = 1;
    var loading = false;
    var baseUrl = 'page/' + journalId + '/';

    function setupFromData(data) {
        if (data.upload_url) uploadUrl = data.upload_url;
        if (data.allowed_formats) allowedFormats = data.allowed_formats;
        if (data.crop_ratio) cropRatio = data.crop_ratio;
        if (data.per_side) perSide = data.per_side;
        if (data.pages) totalPages = data.pages;
        if (fileInput && allowedFormats.length) {
            fileInput.accept = allowedFormats.join(',');
        }
    }

    /* =========================================
       Construcción de grid
       ========================================= */

    function buildGrid(start, end, stamps) {
        var stampMap = {};
        if (stamps) {
            for (var k = 0; k < stamps.length; k++) {
                stampMap[stamps[k].number] = stamps[k];
            }
        }

        var mid = Math.min(start + perSide - 1, end);

        var leftPage = document.createElement('div');
        leftPage.className = 'journal-page journal-left';
        var leftGrid = document.createElement('div');
        leftGrid.className = 'page-grid';
        for (var i = start; i <= mid; i++) {
            var cell = document.createElement('div');
            cell.className = 'grid-cell';
            cell.dataset.cell = i;
            var span = document.createElement('span');
            span.className = 'cell-number';
            span.textContent = i;
            cell.appendChild(span);
            addStampToCell(cell, stampMap[i]);
            leftGrid.appendChild(cell);
        }
        leftPage.appendChild(leftGrid);

        var spine = document.createElement('div');
        spine.className = 'journal-spine';

        var rightPage = document.createElement('div');
        rightPage.className = 'journal-page journal-right';
        var rightGrid = document.createElement('div');
        rightGrid.className = 'page-grid';
        for (var j = mid + 1; j <= end; j++) {
            var cell2 = document.createElement('div');
            cell2.className = 'grid-cell';
            cell2.dataset.cell = j;
            var span2 = document.createElement('span');
            span2.className = 'cell-number';
            span2.textContent = j;
            cell2.appendChild(span2);
            addStampToCell(cell2, stampMap[j]);
            rightGrid.appendChild(cell2);
        }
        rightPage.appendChild(rightGrid);

        container.innerHTML = '';
        container.appendChild(leftPage);
        container.appendChild(spine);
        container.appendChild(rightPage);
    }

    function addStampToCell(cell, stamp) {
        if (!stamp) return;
        var img = document.createElement('img');
        img.className = 'cell-image';
        img.src = stamp.thumb_url;
        img.alt = 'Sello ' + cell.dataset.cell;
        cell.dataset.fullUrl = stamp.full_url;
        cell.classList.add('has-image');
        cell.appendChild(img);
    }

    function applyPageData(data) {
        currentPage = data.page;
        spread.dataset.page = currentPage;
        indicator.innerHTML = '<span>' + data.start + ' - ' + data.end + '</span>';
        btnPrev.classList.toggle('hidden', currentPage <= 1);
        btnNext.classList.toggle('hidden', currentPage >= totalPages);
    }

    /* =========================================
       Paginación
       ========================================= */

    function loadPage(newPage, direction) {

        if (loading) return;
        loading = true;

        btnPrev.disabled = true;
        btnNext.disabled = true;

        flip.className = 'page-flip';

        if (direction === 'next') {
            flip.style.left = '50%';
            flip.style.right = '0';
            flip.style.top = '0';
            flip.style.bottom = '0';
            flip.style.transformOrigin = 'left center';
            void flip.offsetWidth;
            flip.classList.add('flipping-next');
        } else {
            flip.style.left = '0';
            flip.style.right = '50%';
            flip.style.top = '0';
            flip.style.bottom = '0';
            flip.style.transformOrigin = 'right center';
            void flip.offsetWidth;
            flip.classList.add('flipping-prev');
        }

        setTimeout(function () {
            fetch(baseUrl + newPage)
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    setupFromData(data);
                    buildGrid(data.start, data.end, data.stamps || []);
                    applyPageData(data);
                })
                .catch(function () {
                    flip.className = 'page-flip';
                    loading = false;
                    btnPrev.disabled = false;
                    btnNext.disabled = false;
                });
        }, 450);

        setTimeout(function () {
            flip.className = 'page-flip';
            loading = false;
            btnPrev.disabled = false;
            btnNext.disabled = false;
        }, 900);
    }

    btnPrev.addEventListener('click', function () {
        if (currentPage > 1) loadPage(currentPage - 1, 'prev');
    });

    btnNext.addEventListener('click', function () {
        loadPage(currentPage + 1, 'next');
    });

    function loadInitial() {
        fetch(baseUrl + '1')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                setupFromData(data);
                buildGrid(data.start, data.end, data.stamps || []);
                applyPageData(data);
            });
    }

    loadInitial();

    /* =========================================
       Input de archivo oculto
       ========================================= */

    var fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.style.display = 'none';
    document.body.appendChild(fileInput);

    var activeCell = null;

    fileInput.addEventListener('change', function () {
        if (!fileInput.files.length || !activeCell) return;
        var file = fileInput.files[0];

        if (allowedFormats.length && allowedFormats.indexOf(file.type) === -1) {
            alert('Formato no permitido: ' + file.type);
            fileInput.value = '';
            return;
        }

        openCrop(file, activeCell);
        fileInput.value = '';
    });

    container.addEventListener('click', function (e) {
        var cell = e.target.closest('.grid-cell');
        if (!cell) return;
        if (cell.classList.contains('has-image')) {
            Fancybox.show([{ src: cell.dataset.fullUrl }]);
        } else {
            activeCell = cell;
            fileInput.click();
        }
    });

    /* =========================================
       Utilidad: dataURL a Blob
       ========================================= */

    function dataURLtoBlob(dataURL) {
        var parts = dataURL.split(',');
        var mime = parts[0].match(/:(.*?);/)[1];
        var bstr = atob(parts[1]);
        var n = bstr.length;
        var u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new Blob([u8arr], { type: mime });
    }

    /* =========================================
       Modal de recorte
       ========================================= */

    function openCrop(file, targetCell) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = new Image();
            img.onload = function () {
                showCropUI(img, targetCell, file.type);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function showCropUI(img, targetCell, fileType) {
        var RATIO = cropRatio.w / cropRatio.h;

        // Overlay
        var overlay = document.createElement('div');
        overlay.className = 'crop-overlay';

        // Tamaño del frame: máx 55vh de alto, ajustado al viewport
        var maxFrameH = Math.min(window.innerHeight * 0.55, 500);
        var frameH = maxFrameH;
        var frameW = frameH * RATIO;

        if (frameW > window.innerWidth * 0.85) {
            frameW = window.innerWidth * 0.85;
            frameH = frameW / RATIO;
        }

        // Container
        var cropBox = document.createElement('div');
        cropBox.className = 'crop-container';
        cropBox.style.width = frameW + 'px';
        cropBox.style.height = frameH + 'px';
        cropBox.style.alignItems = 'flex-start';
        cropBox.style.justifyContent = 'flex-start';

        // Imagen: escalar para que cubra el frame
        var scale = Math.max(frameW / img.naturalWidth, frameH / img.naturalHeight);
        var imgW = img.naturalWidth * scale;
        var imgH = img.naturalHeight * scale;

        var imgEl = document.createElement('img');
        imgEl.className = 'crop-image';
        imgEl.src = img.src;
        imgEl.style.width = imgW + 'px';
        imgEl.style.height = imgH + 'px';

        // Frame
        var frame = document.createElement('div');
        frame.className = 'crop-frame';
        frame.style.width = frameW + 'px';
        frame.style.height = frameH + 'px';

        cropBox.appendChild(imgEl);
        cropBox.appendChild(frame);
        overlay.appendChild(cropBox);

        // Estado de paneo/zoom - INICIAR DESDE ESQUINA SUPERIOR IZQUIERDA
        var imgX = 0;
        var imgY = 0;
        var zoom = 1;

        function applyTransform() {
            imgEl.style.transform = 'translate(' + imgX + 'px,' + imgY + 'px) scale(' + zoom + ')';
        }

        applyTransform();

        // --- Paneo con ratón ---
        var dragging = false;
        var dragStartX, dragStartY, dragImgX, dragImgY;

        cropBox.addEventListener('mousedown', function (e) {
            e.preventDefault();
            dragging = true;
            dragStartX = e.clientX;
            dragStartY = e.clientY;
            dragImgX = imgX;
            dragImgY = imgY;
            cropBox.style.cursor = 'grabbing';
        });

        document.addEventListener('mousemove', onMouseMove);
        function onMouseMove(e) {
            if (!dragging) return;
            imgX = dragImgX + (e.clientX - dragStartX);
            imgY = dragImgY + (e.clientY - dragStartY);
            applyTransform();
        }

        document.addEventListener('mouseup', onMouseUp);
        function onMouseUp() {
            if (!dragging) return;
            dragging = false;
            cropBox.style.cursor = 'grab';
        }

        // --- Paneo con touch ---
        var touchDragging = false;
        var touchStartX, touchStartY, touchImgX, touchImgY;

        cropBox.addEventListener('touchstart', function (e) {
            if (e.touches.length !== 1) return;
            e.preventDefault();
            touchDragging = true;
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
            touchImgX = imgX;
            touchImgY = imgY;
        }, { passive: false });

        cropBox.addEventListener('touchmove', function (e) {
            if (!touchDragging || e.touches.length !== 1) return;
            e.preventDefault();
            imgX = touchImgX + (e.touches[0].clientX - touchStartX);
            imgY = touchImgY + (e.touches[0].clientY - touchStartY);
            applyTransform();
        }, { passive: false });

        cropBox.addEventListener('touchend', function () {
            touchDragging = false;
        });

        cropBox.style.cursor = 'grab';

        // --- Zoom con rueda ---
        cropBox.addEventListener('wheel', function (e) {
            e.preventDefault();
            var delta = e.deltaY > 0 ? -0.1 : 0.1;
            zoom = Math.max(0.2, Math.min(5, zoom + delta));
            applyTransform();
        }, { passive: false });

        // --- Controles ---
        var controls = document.createElement('div');
        controls.className = 'crop-controls';

        // Barra de zoom
        var zoomBar = document.createElement('div');
        zoomBar.className = 'crop-zoom-bar';

        var btnZoomOut = document.createElement('button');
        btnZoomOut.className = 'crop-zoom-btn';
        btnZoomOut.textContent = '\u2212';
        btnZoomOut.addEventListener('click', function () {
            zoom = Math.max(0.2, zoom - 0.15);
            applyTransform();
        });

        var btnZoomIn = document.createElement('button');
        btnZoomIn.className = 'crop-zoom-btn';
        btnZoomIn.textContent = '+';
        btnZoomIn.addEventListener('click', function () {
            zoom = Math.min(5, zoom + 0.15);
            applyTransform();
        });

        zoomBar.appendChild(btnZoomOut);
        zoomBar.appendChild(btnZoomIn);

        // Botón cancelar
        var btnCancel = document.createElement('button');
        btnCancel.className = 'crop-btn crop-btn-cancel';
        btnCancel.textContent = 'Cancelar';

        // Botón aplicar
        var btnApply = document.createElement('button');
        btnApply.className = 'crop-btn crop-btn-apply';
        btnApply.textContent = 'Aplicar';

        controls.appendChild(zoomBar);
        controls.appendChild(btnCancel);
        controls.appendChild(btnApply);
        overlay.appendChild(controls);
        document.body.appendChild(overlay);

        // --- Funciones de limpieza ---
        function cleanup() {
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
            document.body.removeChild(overlay);
        }

        btnCancel.addEventListener('click', cleanup);

        btnApply.addEventListener('click', function () {
            var dpr = 2;
            var cw = Math.round(frameW * dpr);
            var ch = Math.round(frameH * dpr);

            var canvas = document.createElement('canvas');
            canvas.width = cw;
            canvas.height = ch;
            var ctx = canvas.getContext('2d');

            // Replicar exactamente la transformación CSS en el canvas
            ctx.scale(dpr, dpr);
            ctx.translate(imgX, imgY);
            ctx.scale(zoom, zoom);
            ctx.drawImage(img, 0, 0, imgW, imgH);

            // Calcular la posición real del crop frame en coordenadas del canvas
            var extractX = Math.max(0, imgX * dpr);
            var extractY = Math.max(0, imgY * dpr);
            var extractW = Math.min(frameW * dpr, imgW * dpr - extractX);
            var extractH = Math.min(frameH * dpr, imgH * dpr - extractY);

            // Crear un nuevo canvas para el resultado recortado
            var cropCanvas = document.createElement('canvas');
            cropCanvas.width = extractW;
            cropCanvas.height = extractH;
            var cropCtx = cropCanvas.getContext('2d');

            // Dibujar solo la parte recortada
            cropCtx.drawImage(
                canvas,
                extractX, extractY, extractW, extractH,
                0, 0, extractW, extractH
            );

            var dataURL = cropCanvas.toDataURL('image/webp', 0.90);

            // Obtener datos para la subida
            var cellNumber = parseInt(targetCell.dataset.cell);
            if (!journalId) {
                alert('Error: ID del journal no disponible.');
                cleanup();
                return;
            }

            // Subir al servidor
            var blob = dataURLtoBlob(dataURL);
            var formData = new FormData();
            formData.append('file', blob, cellNumber + '.webp');
            formData.append('number', cellNumber);
            formData.append('journal_id', journalId);

            targetCell.classList.add('uploading');

            if (!uploadUrl) {
                alert('Error: URL de subida no disponible.');
                cleanup();
                return;
            }

            fetch(uploadUrl, {
                method: 'POST',
                body: formData
            })
            .then(function (r) { return r.json(); })
            .then(function (response) {
                targetCell.classList.remove('uploading');
                if (response.success) {
                    var newImg = document.createElement('img');
                    newImg.className = 'cell-image';
                    newImg.src = response.thumb_url;
                    newImg.alt = 'Sello ' + cellNumber;
                    targetCell.dataset.fullUrl = response.full_url;
                    targetCell.classList.add('has-image');
                    targetCell.appendChild(newImg);
                } else {
                    alert('Error al subir la imagen: ' + (response.message || 'Error desconocido'));
                }
            })
            .catch(function () {
                targetCell.classList.remove('uploading');
                alert('Error de conexión al subir la imagen.');
            });

            cleanup();
        });
    }

})();
