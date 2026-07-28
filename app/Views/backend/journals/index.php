<section class="section">

    <div class="level mb-6">
        <div class="level-left">
            <h1 class="title">Journals</h1>
        </div>
        <div class="level-right">
            <a href="<?= base_url('admin/journals/new/') ?>" class="button is-primary"><span class="icon"><i class="fa-solid fa-plus"></i></span> <span>Añadir</span></a>
        </div>
    </div>

    <div class="box">
        <table class="table is-fullwidth is-striped is-hoverable">

            <thead>
                <tr>
                    <th class="is-narrow has-text-centered">ID</th>
                    <th>Nombre</th>
                    <th class="is-narrow has-text-centered">Páginas</th>
                    <th class="is-narrow has-text-centered">Stamps</th>
                    <th class="is-narrow has-text-centered">Estado</th>
                    <th class="is-narrow has-text-centered">Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php if (empty($journals)): ?>

                    <tr><td colspan="99" class="has-text-centered">No hay journals</td></tr>

                <?php else: ?>

                    <?php foreach ($journals as $journal): ?>

                        <tr>
                            <td class="has-text-centered"><?= $journal->id ?></td>
                            <td><?= $journal->name ?></td>                            
                            <td class="has-text-centered"><?= $journal->pages ?? 0 ?></td>
                            <td class="has-text-centered"><?= $journal->stamps ?? 0 ?></td>
                            <td>
                                <span class="tag is-medium is-<?= $journal->status === 'STARTED' ? 'success' : ($journal->status === 'FINISHED' ? 'info' : 'light') ?>"><?= $journal->status ?></span>
                            </td>
                            <td class="has-text-centered">
                                <a href="<?= base_url("admin/journals/{$journal->id}/edit/") ?>" class="button is-small is-dark is-inline-block"><span class="icon"><i class="fa-solid fa-pen"></i></span></a>
                                <form method="POST" action="<?= base_url("admin/journals/{$journal->id}") ?>" class="is-inline-block" onsubmit="return confirm('¿Eliminar este journal?')">
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