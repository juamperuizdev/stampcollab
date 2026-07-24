<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin' ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        html { background-color: #f5f5f5; }
        .sidebar { width: 240px; min-height: 100vh; background-color: #363636; position: fixed; top: 0; left: 0; z-index: 10; }
        .sidebar a { color: #dbdbdb; display: block; padding: 0.75rem 1.25rem; transition: background-color 0.2s; }
        .sidebar a:hover, .sidebar a.is-active { background-color: #4a4a4a; color: #fff; }
        .sidebar .menu-label { color: #7a7a7a; padding: 0.75rem 1.25rem 0.25rem; text-transform: uppercase; font-size: 0.75rem; }
        .sidebar .admin-user { padding: 1.25rem; color: #dbdbdb; border-bottom: 1px solid #4a4a4a; }
        .main-content { margin-left: 240px; padding: 1.5rem 2rem; }
    </style>

</head>
<body>

<aside class="sidebar">
    <div class="admin-user">
        <strong><?= esc(session('administrator')->name) ?> <?= esc(session('administrator')->surname) ?></strong>
    </div>
    <nav class="menu">
        <p class="menu-label">General</p>
        <a href="<?= base_url('/admin/dashboard/') ?>" class="<?= ($title ?? '') === 'Dashboard' ? 'is-active' : '' ?>">Dashboard</a>
        <p class="menu-label">Gestión</p>
        <a href="<?= base_url('/admin/administrators/') ?>" class="<?= ($title ?? '') === 'Administradores' ? 'is-active' : '' ?>">Administradores</a>
        <a href="<?= base_url('/admin/journals/') ?>" class="<?= ($title ?? '') === 'Journals' ? 'is-active' : '' ?>">Journals</a>
        <a href="<?= base_url('/admin/stamps/') ?>" class="<?= ($title ?? '') === 'Stamps' ? 'is-active' : '' ?>">Stamps</a>
        <p class="menu-label">Sesión</p>
        <a href="<?= base_url('/admin/logout/') ?>">Cerrar sesión</a>
    </nav>
</aside>

<div class="main-content">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="notification is-success is-light">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="notification is-danger is-light">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="notification is-danger is-light">
            <ul>
            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
