<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - StampCollab</title>

    <?= view('frontend/scripts-frontend') ?>

    <style>
        .about-wrapper {
            display: flex;
            justify-content: center;
            padding: 3rem 1.5rem;
            min-height: calc(100vh - 130px);
        }
        .about-box {
            max-width: 640px;
            width: 100%;
            background: #fff;
            border-radius: 6px;
            padding: 2.5rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        .about-box h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #333;
        }
        .about-box h2 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.4rem;
            color: #555;
        }
        .about-box p {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #444;
            margin-bottom: 0.8rem;
        }
        .about-box hr {
            border: none;
            border-top: 1px solid #eee;
            margin: 1.2rem 0;
        }
    </style>

</head>
<body>

    <header class="site-header">
        <div class="header-content">
            <a href="<?= base_url() ?>" class="logo-link">
                <img src="<?= base_url('public/assets/logo/stampcollab.webp') ?>" alt="StampCollab" class="logo-img">
            </a>
            <nav class="header-nav">
                <a href="<?= base_url('about/') ?>" class="nav-link nav-about">about</a>
            </nav>
        </div>
    </header>

    <div class="about-wrapper">
        <div class="about-box">
            <h1>About StampCollab</h1>
            <p>
                StampCollab is a collaborative platform where stamp collectors and enthusiasts
                can build virtual stamp albums together. Each album (called a "journal") is
                divided into a grid of cells, and participants take turns filling the cells
                with their own stamp images. The result is a collective digital album that
                grows with each contribution.
            </p>

            <hr>

            <h2>How it works</h2>
            <p>
                A journal is opened with a defined number of pages and stamps per page.
                Visitors can click on any empty cell, upload a stamp image from their device,
                and crop it to fit the cell. Once submitted, the stamp is immediately visible
                in the journal for everyone to see.
            </p>

            <h2>Privacy first</h2>
            <p>
                StampCollab does not require registration or collect personal data. All
                contributions are stored anonymously. The only metadata recorded is a
                timestamp and a non-identifiable IP address, used solely to prevent abuse.
                No cookies, no tracking, no profiling.
            </p>

            <h2>Built with</h2>
            <p>
                StampCollab is built with CodeIgniter 4, PHP 8.4, and Bulma CSS. Images are
                processed server-side with GD and stored as WebP for optimal performance.
            </p>

            <hr>

            <h2>Author</h2>
            <p>
                Created by <strong>Juampe Ruiz</strong> &mdash;
                <a href="https://juamperuiz.es" target="_blank" rel="noopener">juamperuiz.es</a>
            </p>
            <p>
                <a href="https://github.com/juamperuizdev/stampcollab" target="_blank" rel="noopener">
                    <i class="fa-brands fa-github"></i> GitHub
                </a>
            </p>
        </div>
    </div>

</body>
</html>
