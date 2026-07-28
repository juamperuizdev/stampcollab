<h1 class="title"><?= $title ?? '' ?></h1>

<form method="POST" action="<?= base_url('admin/administrators' . (isset($administrator) ? "/{$administrator->id}" : '')) ?>">
    
    <?php if (isset($administrator)): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <div class="field">
        <label class="label">Nombre <span class="has-text-danger">*</span></label>
        <div class="control">
            <input class="input" type="text" name="name" value="<?= old('name', $administrator->name ?? '') ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Apellido <span class="has-text-danger">*</span></label>
        <div class="control">
            <input class="input" type="text" name="surname" value="<?= old('surname', $administrator->surname ?? '') ?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Email <span class="has-text-danger">*</span></label>
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

    <div class="buttons mt-6">
        <a class="button is-dark is-outlined" href="<?= base_url('admin/administrators/') ?>"><span class="icon"><i class="fa-solid fa-arrow-left"></i></span> <span>Cancelar</span></a>
        <button class="button is-primary" type="submit"><span class="icon"><i class="fa-solid fa-save"></i></span> <span>Guardar</span></button>
    </div>

</form>
