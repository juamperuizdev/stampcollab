<div class="level">
    <div class="level-left">
        <h1 class="title">Administradores</h1>
    </div>
    <div class="level-right">
        <a href="<?= base_url('/admin/administrators/new/') ?>" class="button is-link">Nuevo</a>
    </div>
</div>

<table class="table is-fullwidth is-striped is-hoverable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($administrators)): ?>
            <tr><td colspan="5" class="has-text-centered">No hay administradores.</td></tr>
        <?php else: ?>
            <?php foreach ($administrators as $admin): ?>
                <tr>
                    <td><?= $admin->id ?></td>
                    <td><?= esc($admin->name) ?> <?= esc($admin->surname) ?></td>
                    <td><?= esc($admin->email) ?></td>
                    <td>
                        <span class="tag <?= $admin->status ? 'is-success' : 'is-danger' ?> is-clickable"
                              onclick="toggleStatus(<?= $admin->id ?>, this)"
                              style="cursor:pointer" title="Clic para cambiar estado">
                            <?= $admin->status ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= base_url("/admin/administrators/{$admin->id}/edit/") ?>" class="button is-small is-info">Editar</a>
                        <form method="POST" action="<?= base_url("/admin/administrators/{$admin->id}") ?>" class="is-inline-block" onsubmit="return confirm('¿Eliminar este administrador?')">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="button is-small is-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script>
function toggleStatus(id, el) {
    $.ajax({
        url: '<?= base_url('/admin/administrators/') ?>' + id + '/toggle-status',
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                el.textContent = data.label;
                el.classList.remove('is-success', 'is-danger');
                el.classList.add(data.status ? 'is-success' : 'is-danger');
                Toastify({
                    text: data.label,
                    duration: 2000,
                    gravity: 'bottom',
                    position: 'center',
                    style: { background: data.status ? 'linear-gradient(to right, #00b09b, #96c93d)' : 'linear-gradient(to right, #ff9800, #f57c00)' }
                }).showToast();
            }
        }
    });
}
</script>
