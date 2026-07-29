# StampCollab

StampCollab is a collaborative platform where stamp collectors and enthusiasts can build virtual stamp albums together. Each album (called a "journal") is divided into a grid of cells, and participants take turns filling the cells with their own stamp images. The result is a collective digital album that grows with each contribution.

## How it works

A journal is opened with a defined number of pages and stamps per page. Visitors can click on any empty cell, upload a stamp image from their device, and crop it to fit the cell. Once submitted, the stamp is immediately visible in the journal for everyone to see.

## Privacy first

StampCollab does not require registration or collect personal data. All contributions are stored anonymously. The only metadata recorded is a timestamp and a non-identifiable IP address, used solely to prevent abuse. No cookies, no tracking, no profiling.

## Tech stack

- **Backend:** CodeIgniter 4, PHP 8.4
- **Frontend:** Bulma CSS, vanilla JavaScript
- **Image processing:** GD library (server-side), Cropper.js (client-side crop)
- **Storage:** WebP format (quality 85) with automatic thumbnail generation (210x250)
- **Email:** Brevo SMTP (transactional notifications)

## Getting started

### Requirements

- PHP 8.3+
- MySQL / MariaDB
- Composer
- GD extension with WebP support

### Installation

```bash
git clone https://github.com/juamperuizdev/stampcollab.git
cd stampcollab
composer install
cp env .env
```

Configure `.env` with your database credentials and email settings, then run the migrations:

```bash
php spark migrate
```

## Author

Created by **Juampe Ruiz** — [juamperuiz.es](https://juamperuiz.es)

[GitHub](https://github.com/juamperuizdev/stampcollab)
