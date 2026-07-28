<section class="section">

    <h1 class="title mb-6"><?= $title ?? 'Nuevo Stamp' ?></h1>

    <form method="POST" action="<?= base_url('admin/stamps' . (isset($stamp) ? "/{$stamp->id}" : '')) ?>">

        <?php if (isset($stamp)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <div class="columns">
            <div class="column is-narrow">
                <div class="field">
                    <label class="label">Estado <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="status">
                                <option value="1" <?= (old('status', $stamp->status ?? 1) == 1) ? 'selected' : '' ?>>Activo</option>
                                <option value="0" <?= (old('status', $stamp->status ?? 1) == 0) ? 'selected' : '' ?>>Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($journals)): ?>
                <div class="column">
                    <div class="field">
                        <label class="label">Journal</label>
                        <div class="control">
                            <div class="select">
                                <select name="id_journal">
                                    <option value="">— Sin journal —</option>
                                    <?php foreach ($journals as $journal): ?>
                                        <option value="<?= $journal->id ?>"
                                            <?= (old('id_journal', $stamp->id_journal ?? '') == $journal->id) ? 'selected' : '' ?>>
                                            <?= $journal->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>            
            <?php endif; ?>

        </div>

        <div class="field">
            <label class="label">Número</label>
            <div class="control">
                <input class="input" type="number" name="number"
                    value="<?= old('number', $stamp->number ?? '') ?>">
            </div>
        </div>

        <div class="buttons mt-6">
            <a class="button is-dark is-outlined" href="<?= base_url('admin/stamps/') ?>"><span class="icon"><i class="fa-solid fa-arrow-left"></i></span> <span>Cancelar</span></a>
            <button class="button is-primary" type="submit"><span class="icon"><i class="fa-solid fa-save"></i></span> <span>Guardar</span></button>
        </div>

    </form>

</section>