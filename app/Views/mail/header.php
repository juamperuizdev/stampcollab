<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Mono&display=swap" rel="stylesheet">
</head>

<body style="margin:0;padding:0;background:#f4f4f4;font-family:'Red Hat Mono', monospace; font-optical-sizing: auto; font-weight: 400; font-style: normal;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding:30px 10px;">
                <table role="presentation" align="center" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="padding:30px;background:#7fdbd3;text-align:center;">
                            <?php $base64 = base64_encode(file_get_contents(ROOTPATH . 'public/assets/logo/stampcollab.webp')); ?>
                            <img src="data:image/webp;base64,<?= $base64 ?>" alt="StampCollab" style="max-width:500px;height:auto;" />
                        </td>
                    </tr>