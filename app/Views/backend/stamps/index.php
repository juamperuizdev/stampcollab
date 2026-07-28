<section class="section">

    <div class="level mb-6">
        <div class="level-left">
            <h1 class="title">Stamps</h1>
        </div>
        <div class="level-right">
            <a href="<?= base_url('admin/stamps/new/') ?>" class="button is-primary"><span class="icon"><i class="fa-solid fa-plus"></i></span> <span>Añadir</span></a>
        </div>
    </div>

    <?php if (isset($journals)): ?>
        <div class="field">
            <label class="label">Filtrar por journal</label>
            <div class="control">
                <div class="select">
                    <select id="journalFilter" onchange="loadStamps(this.value)">
                        <?php foreach ($journals as $journal): ?>
                            <option value="<?= $journal->id ?>" <?= $journal->id === $selected ? 'selected' : '' ?>>
                                <?= esc($journal->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="columns is-multiline mt-4" id="stampsGrid">

        <?php if (empty($stamps)): ?>

            <div class="column">
                <p class="has-text-centered has-text-grey">No hay stamps en este journal</p>
            </div>

        <?php else: ?>

            <?php foreach ($stamps as $stamp):
                $imageUrl = $stamp->image ? base_url('public/uploads/journals/' . $stamp->id_journal . '/thumbs/' . $stamp->image) : base_url('public/assets/image/stamp.png');
                $statusClass = $stamp->status ? 'is-success' : 'is-danger';
                $statusLabel = $stamp->status ? 'Activo' : 'Inactivo';
                ?>

                <div class="column is-1">
                    <div class="box has-text-centered p-3" style="position:relative">
                        <a href="<?= base_url("admin/stamps/{$stamp->id}/edit/") ?>">
                            <img src="<?= $imageUrl ?>" alt="Stamp" style="width:100%;aspect-ratio:21/25;object-fit:contain;display:block">
                        </a>
                        <span class="tag is-light is-small" style="position:absolute;top:0.5rem;right:0.5rem">#<?= $stamp->number ?? '?' ?></span>
                        <p class="mt-2"><span class="tag is-fullwidth <?= $statusClass ?>"><?= $statusLabel ?></span></p>
                        <div class="buttons is-centered mt-2" style="gap:0.25rem">
                            <a href="<?= base_url("admin/stamps/{$stamp->id}/edit/") ?>" class="button is-small is-dark"><span class="icon"><i class="fa-solid fa-pen"></i></span></a>
                            <form method="POST" action="<?= base_url("admin/stamps/{$stamp->id}") ?>" class="is-inline-block" onsubmit="return confirm('¿Eliminar este stamp?')">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="button is-small is-danger"><span class="icon"><i class="fa-solid fa-trash"></i></span></button>
                            </form>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</section>

<script>

    function loadStamps(journalId) {
        if (!journalId) return;

        $.ajax({
            url: '<?= base_url('admin/stamps/by-journal/') ?>' + journalId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                document.getElementById('stampsGrid').innerHTML = data.html;
            }
        });
    }

</script>
