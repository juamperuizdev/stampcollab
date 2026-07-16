<?php
$mid = $start + 24;
?>
<div class="journal-page journal-left">
    <div class="page-grid">
        <?php for ($i = $start; $i <= $mid; $i++): ?>
            <div class="grid-cell" data-cell="<?= $i ?>">
                <span class="cell-number"><?= $i ?></span>
            </div>
        <?php endfor; ?>
    </div>
</div>
<div class="journal-spine"></div>
<div class="journal-page journal-right">
    <div class="page-grid">
        <?php for ($i = $mid + 1; $i <= $end; $i++): ?>
            <div class="grid-cell" data-cell="<?= $i ?>">
                <span class="cell-number"><?= $i ?></span>
            </div>
        <?php endfor; ?>
    </div>
</div>
