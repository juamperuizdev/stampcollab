<section class="section">
        
    <div class="level mb-6">
        <div class="level-left">
            <h1 class="title">Stamps</h1>
        </div>
        <div class="level-right">
            <a href="<?= base_url('admin/stamps/new/') ?>" class="button is-primary"><span class="icon"><i class="fa-solid fa-plus"></i></span> <span>Añadir</span></a>
        </div>
    </div>

    <div class="box">
        <table class="table is-fullwidth is-striped is-hoverable">

            <thead>
                <tr>
                    <th class="is-narrow has-text-centered">ID</th>
                    <th>Journal</th>
                    <th class="is-narrow has-text-centered">Número</th>
                    <th class="is-narrow has-text-centered">Estado</th>
                    <th class="is-narrow has-text-centered">Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php if (empty($stamps)): ?>

                    <tr><td colspan="99" class="has-text-centered">No hay stamps</td></tr>
                <?php else: ?>

                    <?php foreach ($stamps as $stamp): ?>

                        <tr>
                            <td class="has-text-centered"><?= $stamp->id ?></td>
                            <td><?= $stamp->journal ?></td>
                            <td class="has-text-centered"><?= $stamp->number ?? '-' ?></td>
                            <td class="has-text-centered"><span class="tag is-medium <?= $stamp->status ? 'is-success' : 'is-danger' ?>"><?= $stamp->status ? 'Activo' : 'Inactivo' ?></span></td>
                            <td class="has-text-centered">
                                <a href="<?= base_url("admin/stamps/{$stamp->id}/edit/") ?>" class="button is-small is-dark is-inline-block"><span class="icon"><i class="fa-solid fa-pen"></i></span></a>
                                <form method="POST" action="<?= base_url("admin/stamps/{$stamp->id}") ?>" class="is-inline-block" onsubmit="return confirm('¿Eliminar este stamp?')">
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