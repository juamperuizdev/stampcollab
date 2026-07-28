<section class="section">
        
    <div class="level mb-6">
        <div class="level-left">
            <h1 class="title">Administradores</h1>
        </div>
        <div class="level-right">
            <a href="<?= base_url('admin/administrators/new/') ?>" class="button is-primary"><span class="icon"><i class="fa-solid fa-plus"></i></span> <span>Añadir</span></a>
        </div>
    </div>

    <div class="box">
        <table class="table is-fullwidth is-striped is-hoverable">

            <thead>
                <tr>
                    <th class="is-narrow has-text-centered">ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th class="is-narrow has-text-centered">Estado</th>
                    <th class="is-narrow has-text-centered">Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php if (empty($administrators)): ?>

                    <tr><td colspan="99" class="has-text-centered">No hay administradores</td></tr>

                <?php else: ?>

                    <?php foreach ($administrators as $admin): ?>

                        <tr>
                            <td class="has-text-centered"><?= $admin->id ?></td>
                            <td><?= $admin->name ?> <?= $admin->surname ?></td>
                            <td><?= $admin->email ?></td>
                            <td class="has-text-centered">
                                <span class="tag is-medium <?= $admin->status ? 'is-success' : 'is-danger' ?> is-clickable" onclick="toggleStatus(<?= $admin->id ?>, this)" title="Clic para cambiar estado"><?= $admin->status ? 'Activo' : 'Inactivo' ?></span>
                            </td>
                            <td class="has-text-centered">
                                <a href="<?= base_url("admin/administrators/{$admin->id}/edit/") ?>" class="button is-small is-dark is-inline-block"><span class="icon"><i class="fa-solid fa-pen"></i></span></a>
                                <form method="POST" action="<?= base_url("admin/administrators/{$admin->id}") ?>" onsubmit="return confirm('¿Eliminar este administrador?')" class="is-inline-block">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="button is-small is-danger"><span class="icon"><i class="fa-solid fa-trash"></i></span></button>
                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>
        </table>

    </div>

</section>

<script>

    function toggleStatus(id, el) {
        $.ajax({
            url: '<?= base_url('admin/administrators/') ?>' + id + '/toggle-status',
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
