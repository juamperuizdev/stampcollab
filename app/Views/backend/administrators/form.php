<h1 class="title"><?= $title ?? '' ?></h1>

<form method="POST" action="<?= base_url('/admin/administrators' . (isset($administrator) ? "/{$administrator->id}" : '')) ?>">
    
    <?php if (isset($administrator)): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <div class="field">
        <label class="label">Nombre</label>
        <div class="control">
            <input class="input" type="text" name="name" value="<?= old('name', $administrator->name ?? '') ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Apellido</label>
        <div class="control">
            <input class="input" type="text" name="surname" value="<?= old('surname', $administrator->surname ?? '') ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input class="input" type="email" name="email" value="<?= old('email', $administrator->email ?? '') ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Contraseña <?= isset($administrator) ? '(dejar vacío para no cambiar)' : '' ?></label>
        <div class="control">
            <input class="input" type="password" name="password" <?= isset($administrator) ? '' : 'required' ?>>
        </div>
    </div>

    <div class="field is-grouped mt-5">
        <div class="control">
            <button class="button is-link" type="submit">Guardar</button>
        </div>
        <div class="control">
            <a href="<?= base_url('/admin/administrators/') ?>" class="button is-light">Cancelar</a>
        </div>
    </div>
</form>
