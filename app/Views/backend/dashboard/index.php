<section class="section">
    
    <h1 class="title mb-6">Dashboard</h1>

    <div class="columns">
        <div class="column">
            <div class="box has-text-centered">
                <p class="heading">Administradores</p>
                <p class="title"><?= $totalAdmins ?? 0 ?></p>
                <a href="<?= base_url('admin/administrators/') ?>" class="button is-small is-dark mt-2"><span class="icon"><i class="fa-solid fa-search"></i></span> <span>Ver</span></a>
            </div>
        </div>
        <div class="column">
            <div class="box has-text-centered">
                <p class="heading">Journals</p>
                <p class="title"><?= $totalJournals ?? 0 ?></p>
                <a href="<?= base_url('admin/journals/') ?>" class="button is-small is-dark mt-2"><span class="icon"><i class="fa-solid fa-search"></i></span> <span>Ver</span></a>
            </div>
        </div>
        <div class="column">
            <div class="box has-text-centered">
                <p class="heading">Stamps</p>
                <p class="title"><?= $totalStamps ?? 0 ?></p>
                <a href="<?= base_url('admin/stamps/') ?>" class="button is-small is-dark mt-2"><span class="icon"><i class="fa-solid fa-search"></i></span> <span>Ver</span></a>
            </div>
        </div>
    </div>

</section>