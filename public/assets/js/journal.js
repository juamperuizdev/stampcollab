(function () {

    var spread = document.getElementById('journalSpread');
    var container = document.getElementById('gridContainer');
    var indicator = document.getElementById('pageIndicator');
    var btnPrev = document.getElementById('btnPrev');
    var btnNext = document.getElementById('btnNext');
    var flip = document.getElementById('pageFlip');
    var currentPage = parseInt(spread.dataset.page);
    var loading = false;
    var baseUrl = 'page/';

    function buildGrid(start, end) {
        var mid = start + 24;

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
            rightGrid.appendChild(cell2);
        }
        rightPage.appendChild(rightGrid);

        container.innerHTML = '';
        container.appendChild(leftPage);
        container.appendChild(spine);
        container.appendChild(rightPage);
    }

    function applyPageData(data) {
        currentPage = data.page;
        spread.dataset.page = currentPage;
        indicator.innerHTML = '<span>' + data.start + ' - ' + data.end + '</span>';
        btnPrev.classList.toggle('hidden', currentPage <= 1);
    }

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
                    buildGrid(data.start, data.end);
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
                buildGrid(data.start, data.end);
                applyPageData(data);
            });
    }

    loadInitial();

})();
