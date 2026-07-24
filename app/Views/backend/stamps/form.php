<h1 class="title"><?= $title ?></h1>

<form method="POST" action="<?= base_url('/admin/stamps' . (isset($stamp) ? "/{$stamp->id}" : '')) ?>">
    <?php if (isset($stamp)): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <div class="field">
        <label class="label">Journal</label>
        <div class="control">
            <div class="select">
                <select name="id_journal">
                    <option value="">— Sin journal —</option>
                    <?php foreach ($journals as $journal): ?>
                        <option value="<?= $journal->id ?>"
                            <?= (old('id_journal', $stamp->id_journal ?? '') == $journal->id) ? 'selected' : '' ?>>
                            <?= esc($journal->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Número</label>
        <div class="control">
            <input class="input" type="number" name="number"
                   value="<?= old('number', $stamp->number ?? '') ?>">
        </div>
    </div>

    <div class="field">
        <label class="label">Estado</label>
        <div class="control">
            <div class="select">
                <select name="status">
                    <option value="1" <?= (old('status', $stamp->status ?? 1) == 1) ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= (old('status', $stamp->status ?? 1) == 0) ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>
        </div>
    </div>

    <div class="field is-grouped mt-5">
        <div class="control">
            <button class="button is-link" type="submit">Guardar</button>
        </div>
        <div class="control">
            <a href="<?= base_url('/admin/stamps') ?>" class="button is-light">Cancelar</a>
        </div>
    </div>
</form>
