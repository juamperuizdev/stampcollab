<?= view('mail/header') ?>

<tr>

    <td style="padding:30px;">
        <h1 style="margin:0;color:#fff;font-size:22px;"><?= $subject ?? 'StampCollab' ?></h1>
    </td>

    <td style="padding:30px;">

        <?php if (isset($journalName)): ?>
            <p style="margin:0 0 15px;color:#333;font-size:15px;line-height:1.5;">
                Se ha publicado un nuevo stamp en el journal <strong><?= esc($journalName) ?></strong>.
            </p>
        <?php else: ?>
            <p style="margin:0 0 15px;color:#333;font-size:15px;line-height:1.5;">
                Se ha publicado un nuevo stamp en <strong>StampCollab</strong>.
            </p>
        <?php endif; ?>

        <?php if (isset($thumbUrl)): ?>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" style="padding:15px 0;">
                        <img src="data:image/webp;base64,<?= $thumbUrl ?>" alt="Stamp" style="max-width:210px; height:auto; border:1px solid #ddd;">
                    </td>
                </tr>
            </table>
        <?php endif; ?>

        <?php if (isset($ip) && isset($userAgent)): ?>
            <table role="presentation" width="100%" cellpadding="10" cellspacing="0" style="background:#f9f9f9;border-radius:4px;font-size:13px;color:#555;">
                <tr>
                    <td style="border-bottom:1px solid #eee;font-weight:bold;color:#333;" colspan="2">Información del usuario</td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #eee;width:100px;">IP</td>
                    <td><?= esc($ip) ?></td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #eee;">User Agent</td>
                    <td style="word-break:break-all;"><?= esc($userAgent) ?></td>
                </tr>
            </table>
        <?php endif; ?>

    </td>
    
</tr>

<?= view('mail/footer') ?>