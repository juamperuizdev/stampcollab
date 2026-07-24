<div class="level">
    <div class="level-left">
        <h1 class="title">Stamps</h1>
    </div>
    <div class="level-right">
        <a href="<?= base_url('/admin/stamps/new') ?>" class="button is-link">Nuevo</a>
    </div>
</div>

<table class="table is-fullwidth is-striped is-hoverable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Journal</th>
            <th>Número</th>
            <th>Estado</th>
            <th>IP</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($stamps)): ?>
            <tr><td colspan="6" class="has-text-centered">No hay stamps.</td></tr>
        <?php else: ?>
            <?php foreach ($stamps as $stamp): ?>
                <tr>
                    <td><?= $stamp->id ?></td>
                    <td>
                        <?php
                        $journalName = '';
                        foreach ($journals as $j) {
                            if ($j->id === $stamp->id_journal) {
                                $journalName = $j->name;
                                break;
                            }
                        }
                        echo esc($journalName) ?: '<span class="has-text-grey">—</span>';
                        ?>
                    </td>
                    <td><?= $stamp->number ?? '<span class="has-text-grey">—</span>' ?></td>
                    <td>
                        <span class="tag <?= $stamp->status ? 'is-success' : 'is-danger' ?>">
                            <?= $stamp->status ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </td>
                    <td><code><?= esc($stamp->ip ?? '') ?></code></td>
                    <td>
                        <a href="<?= base_url("/admin/stamps/{$stamp->id}/edit") ?>" class="button is-small is-info">Editar</a>
                        <form method="POST" action="<?= base_url("/admin/stamps/{$stamp->id}") ?>" class="is-inline-block" onsubmit="return confirm('¿Eliminar este stamp?')">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="button is-small is-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
