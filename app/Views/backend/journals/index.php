<div class="level">
    <div class="level-left">
        <h1 class="title">Journals</h1>
    </div>
    <div class="level-right">
        <a href="<?= base_url('/admin/journals/new') ?>" class="button is-link">Nuevo</a>
    </div>
</div>

<table class="table is-fullwidth is-striped is-hoverable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Slug</th>
            <th>Páginas</th>
            <th>Stamps</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($journals)): ?>
            <tr><td colspan="7" class="has-text-centered">No hay journals.</td></tr>
        <?php else: ?>
            <?php foreach ($journals as $journal): ?>
                <tr>
                    <td><?= $journal->id ?></td>
                    <td><?= esc($journal->name) ?></td>
                    <td><code><?= esc($journal->slug) ?></code></td>
                    <td><?= $journal->pages ?></td>
                    <td><?= $journal->stamps ?></td>
                    <td>
                        <span class="tag is-<?= $journal->status === 'STARTED' ? 'success' : ($journal->status === 'FINISHED' ? 'info' : 'light') ?>">
                            <?= $journal->status ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= base_url("/admin/journals/{$journal->id}/edit") ?>" class="button is-small is-info">Editar</a>
                        <form method="POST" action="<?= base_url("/admin/journals/{$journal->id}") ?>" class="is-inline-block" onsubmit="return confirm('¿Eliminar este journal?')">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="button is-small is-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
