<!DOCTYPE html>
<html lang="es" data-theme="light" class="has-background-light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — StampCollab</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

</head>
<body>

    <section class="section mt-6">
        <div class="columns is-centered">
            <div class="column is-4">
                <div class="box p-6">

                    <div class="block">
                        <h1 class="title has-text-centered pb-2">StampCollab</h1>
                        <p class="subtitle has-text-centered mb-5">Acceso al panel de administración</p>
                    </div>

                    <form id="form">
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input class="input" type="email" name="email" required autofocus
                                       value="<?= old('email') ?>">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Contraseña</label>
                            <div class="control">
                                <input class="input" type="password" name="password" required>
                            </div>
                        </div>
                        <div class="field mt-5">
                            <div class="control">
                                <a class="button is-primary is-fullwidth" onclick="javascript:login()">Entrar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>

        function login() {

            var email = $('input[name="email"]').val();
            var password = $('input[name="password"]').val();

            if (!email || !password) {
                Toastify({
                    text: 'Introduce email y contraseña.',
                    duration: 3000,
                    gravity: 'bottom',
                    position: 'center',
                    style: { background: 'linear-gradient(to right, #ff9800, #f57c00)' }
                }).showToast();
                return;
            }

            $.ajax({
                url: '<?= base_url('admin/login') ?>',
                type: 'POST',
                dataType: 'json',
                data: { email: email, password: password },
                success: function(data) {
                    if (data.status) {
                        Toastify({
                            text: data.message,
                            duration: 2000,
                            gravity: 'bottom',
                            position: 'center',
                            style: { background: 'linear-gradient(to right, #00b09b, #96c93d)' }
                        }).showToast();
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 1500);
                    } else {
                        Toastify({
                            text: data.message,
                            duration: 3000,
                            gravity: 'bottom',
                            position: 'center',
                            style: { background: 'linear-gradient(to right, #ff0048, #ce2124)' }
                        }).showToast();
                    }
                },
                error: function() {
                    Toastify({
                        text: 'Error de conexión.',
                        duration: 3000,
                        gravity: 'bottom',
                        position: 'center',
                        style: { background: 'linear-gradient(to right, #ff0048, #ce2124)' }
                    }).showToast();
                }
            });

        }

    </script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

</body>
</html>
