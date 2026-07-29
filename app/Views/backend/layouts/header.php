<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin' ?></title>

    <?= view('backend/layouts/scripts') ?>    

</head>
<body>

<aside class="sidebar">

    <div class="admin-user">
        <?= esc(session('administrator')->name) ?> <?= esc(session('administrator')->surname) ?>
    </div>

    <nav class="menu">
        <p class="menu-label">Backend</p>
        <a href="<?= base_url('admin/dashboard/') ?>" class="<?= ($title ?? '') === 'Dashboard' ? 'is-active' : '' ?>">Dashboard</a>
        <a href="<?= base_url('admin/administrators/') ?>" class="<?= ($title ?? '') === 'Administradores' ? 'is-active' : '' ?>">Administradores</a>
        <a href="<?= base_url('admin/journals/') ?>" class="<?= ($title ?? '') === 'Journals' ? 'is-active' : '' ?>">Journals</a>
        <a href="<?= base_url('admin/stamps/') ?>" class="<?= ($title ?? '') === 'Stamps' ? 'is-active' : '' ?>">Stamps</a>
        <a href="<?= base_url('admin/dashboard/test-email') ?>">Test Email</a>
        <a href="<?= base_url('admin/logout/') ?>">Cerrar sesión</a>
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
