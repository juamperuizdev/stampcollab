<h1 class="title"><?= $title ?></h1>

<form method="POST" action="<?= base_url('/admin/journals' . (isset($journal) ? "/{$journal->id}" : '')) ?>">
    <?php if (isset($journal)): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <div class="field">
        <label class="label">Nombre</label>
        <div class="control">
            <input class="input" type="text" name="name" required
                   value="<?= old('name', $journal->name ?? '') ?>">
        </div>
    </div>

    <div class="field">
        <label class="label">Slug</label>
        <div class="control">
            <input class="input" type="text" name="slug" required
                   value="<?= old('slug', $journal->slug ?? '') ?>">
        </div>
    </div>

    <div class="field">
        <label class="label">Descripción</label>
        <div class="control">
            <textarea class="textarea" name="description"><?= old('description', $journal->description ?? '') ?></textarea>
        </div>
    </div>

    <div class="field">
        <label class="label">Estado</label>
        <div class="control">
            <div class="select">
                <select name="status">
                    <?php
                    $current = old('status', $journal->status ?? 'HIDDEN');
                    foreach (['HIDDEN', 'STARTED', 'FINISHED'] as $opt):
                    ?>
                        <option value="<?= $opt ?>" <?= $current === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="field is-grouped mt-5">
        <div class="control">
            <button class="button is-link" type="submit">Guardar</button>
        </div>
        <div class="control">
            <a href="<?= base_url('/admin/journals') ?>" class="button is-light">Cancelar</a>
        </div>
    </div>
</form>
