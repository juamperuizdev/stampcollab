<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
</head>

<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding:30px 10px;">
                <table role="presentation" align="center" width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="padding:30px;background:#485fc7;text-align:center;">
                            <h1 style="margin:0;color:#fff;font-size:22px;">Nuevo stamp publicado</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;">
                            <p style="margin:0 0 15px;color:#333;font-size:15px;line-height:1.5;">
                                Se ha publicado un nuevo stamp en el journal <strong><?= esc($journalName) ?></strong>.
                            </p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding:15px 0;">
                                        <img src="<?= $thumbUrl ?>" alt="Stamp thumbnail" style="max-width:210px;height:auto;border:1px solid #ddd;border-radius:4px;">
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" width="100%" cellpadding="10" cellspacing="0" style="background:#f9f9f9;border-radius:4px;font-size:13px;color:#555;">
                                <tr>
                                    <td style="border-bottom:1px solid #eee;font-weight:bold;color:#333;" colspan="2">Informacion del visitante</td>
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
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:15px 30px;background:#f4f4f4;text-align:center;font-size:11px;color:#999;">StampCollab</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>