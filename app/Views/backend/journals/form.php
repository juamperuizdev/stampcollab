<section class="section">

    <h1 class="title mb-6"><?= $title ?? 'Nuevo journal' ?></h1>

    <form method="POST" action="<?= base_url('admin/journals' . (isset($journal) ? "/{$journal->id}" : '')) ?>">

        <?php if (isset($journal)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <div class="columns">

            <div class="column is-narrow">
                <div class="field">
                    <label class="label">Estado <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <div class="select">
                            <select name="status">
                                <?php
                                $current = old('status', $journal->status ?? 'HIDDEN');
                                foreach (['HIDDEN', 'STARTED', 'FINISHED'] as $opt): ?>
                                    <option value="<?= $opt ?>" <?= $current === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label">Nombre <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <input class="input" type="text" name="name" required
                            value="<?= old('name', $journal->name ?? '') ?>">
                    </div>
                </div>
            </div>

        </div>

        <div class="field">
            <label class="label">Descripción</label>
            <div class="control">
                <textarea class="textarea" name="description"><?= old('description', $journal->description ?? '') ?></textarea>
            </div>
        </div>

        <div class="buttons mt-6">
            <a class="button is-dark is-outlined" href="<?= base_url('admin/journals/') ?>"><span class="icon"><i class="fa-solid fa-arrow-left"></i></span> <span>Cancelar</span></a>
            <button class="button is-primary" type="submit"><span class="icon"><i class="fa-solid fa-save"></i></span> <span>Guardar</span></button>
        </div>
        
    </form>

</section>