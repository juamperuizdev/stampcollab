<section class="section">

    <h1 class="title mb-6"><?= $title ?? 'Nuevo journal' ?></h1>

    <form method="POST" action="<?= base_url('admin/journals' . (isset($journal) ? "/{$journal->id}" : '')) ?>" enctype="multipart/form-data">

        <?php if (isset($journal)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <div class="columns">

            <div class="column is-narrow">
                <div class="field">
                    <label class="label">Estado <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <div class="select">
                            <select name="status">
                                <?php
                                $current = old('status', $journal->status ?? 'HIDDEN');
                                foreach (['HIDDEN', 'STARTED', 'FINISHED'] as $opt): ?>
                                    <option value="<?= $opt ?>" <?= $current === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label">Nombre <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <input class="input" type="text" name="name" required
                            value="<?= old('name', $journal->name ?? '') ?>">
                    </div>
                </div>
            </div>

        </div>

        <div class="columns">

            <div class="column">
                <div class="field">
                    <label class="label">Páginas</label>
                    <div class="control">
                        <input class="input" type="number" name="pages" min="0"
                            value="<?= old('pages', $journal->pages ?? 0) ?>">
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label">Stamps</label>
                    <div class="control">
                        <input class="input" type="number" name="stamps" min="0"
                            value="<?= old('stamps', $journal->stamps ?? 0) ?>">
                    </div>
                </div>
            </div>

        </div>

        <div class="field">
            <label class="label">Descripción</label>
            <div class="control">
                <textarea class="textarea" name="description"><?= old('description', $journal->description ?? '') ?></textarea>
            </div>
        </div>

        <div class="field">
            <label class="label">Portada</label>

            <?php if (isset($journal) && $journal->cover): ?>
                <div class="mb-3" id="currentCover">
                    <img src="<?= base_url('public/uploads/' . $journal->id . '/' . esc($journal->cover)) ?>" alt="Portada actual" style="max-width:200px;max-height:200px">
                    <p class="help">Portada actual</p>
                    <button class="button is-small is-danger is-outlined mt-1" type="button" onclick="deleteCover(<?= $journal->id ?>)">Eliminar portada</button>
                </div>
            <?php endif; ?>

            <div class="file is-boxed">
                <label class="file-label">
                    <input class="file-input" type="file" id="coverInput" accept="image/jpeg,image/png,image/webp">
                    <span class="file-cta">
                        <span class="file-icon"><i class="fa-solid fa-upload"></i></span>
                        <span class="file-label">Seleccionar imagen</span>
                    </span>
                </label>
            </div>
            <div id="coverPreview" class="mt-3" style="display:none">
                <img src="" alt="Nueva portada" style="max-width:200px;max-height:200px">
                <p class="help">Nueva portada (sin guardar)</p>
            </div>
            <input type="hidden" name="cover" id="coverHidden" value="<?= old('cover', $journal->cover ?? '') ?>">
        </div>

        <div class="buttons mt-6">
            <a class="button is-dark is-outlined" href="<?= base_url('admin/journals/') ?>"><span class="icon"><i class="fa-solid fa-arrow-left"></i></span> <span>Cancelar</span></a>
            <button class="button is-primary" type="submit"><span class="icon"><i class="fa-solid fa-save"></i></span> <span>Guardar</span></button>
        </div>

    </form>

</section>

<!-- Modal para recorte de portada -->
<div class="modal" id="cropModal">
    <div class="modal-background"></div>
    <div class="modal-card" style="width:90%;max-width:800px">
        <header class="modal-card-head">
            <p class="modal-card-title">Recortar portada</p>
            <button class="delete" aria-label="close" onclick="closeCropModal()"></button>
        </header>
        <section class="modal-card-body" style="padding:0">
            <img id="cropImage" src="" alt="Imagen a recortar" style="max-width:100%">
        </section>
        <footer class="modal-card-foot">
            <div class="buttons">
                <button class="button is-primary" onclick="cropAndUpload()"><span class="icon"><i class="fa-solid fa-crop"></i></span> <span>Recortar y subir</span></button>
                <button class="button" onclick="closeCropModal()">Cancelar</button>
            </div>
        </footer>
    </div>
</div>

<script>
var cropper = null;

document.getElementById('coverInput').addEventListener('change', function(e) {
    var file = e.target.files[0];
    if (!file) return;

    var reader = new FileReader();
    reader.onload = function(ev) {
        var img = document.getElementById('cropImage');
        img.onload = function() {
            document.getElementById('cropModal').classList.add('is-active');
            if (cropper) cropper.destroy();
            cropper = new Cropper(img, {
                aspectRatio: 1 / 1,
                viewMode: 1,
                autoCropArea: 1,
            });
        };
        img.src = ev.target.result;
    };
    reader.readAsDataURL(file);
});

function closeCropModal() {
    document.getElementById('cropModal').classList.remove('is-active');
    if (cropper) { cropper.destroy(); cropper = null; }
    document.getElementById('coverInput').value = '';
}

function cropAndUpload() {
    if (!cropper) return;

    var canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
    canvas.toBlob(function(blob) {
        var formData = new FormData();
        formData.append('cover', blob, 'cover.webp');

        $.ajax({
            url: '<?= base_url('admin/journals/upload-cover') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    document.getElementById('coverHidden').value = data.filename;

                    var preview = document.getElementById('coverPreview');
                    preview.querySelector('img').src = '<?= base_url('public/uploads/tmp/') ?>' + data.filename;
                    preview.style.display = 'block';

                    closeCropModal();
                    Toastify({
                        text: 'Portada subida correctamente',
                        duration: 2000,
                        gravity: 'bottom',
                        position: 'center',
                        style: { background: 'linear-gradient(to right, #00b09b, #96c93d)' }
                    }).showToast();
                } else {
                    Toastify({
                        text: data.message || 'Error al subir la portada',
                        duration: 3000,
                        gravity: 'bottom',
                        position: 'center',
                        style: { background: 'linear-gradient(to right, #ff0048, #ce2124)' }
                    }).showToast();
                }
            },
            error: function() {
                Toastify({
                    text: 'Error de conexión al subir la imagen',
                    duration: 3000,
                    gravity: 'bottom',
                    position: 'center',
                    style: { background: 'linear-gradient(to right, #ff0048, #ce2124)' }
                }).showToast();
            }
        });
    }, 'image/webp', 0.9);
}

function deleteCover(id) {
    if (!confirm('¿Eliminar la portada actual?')) return;

    $.ajax({
        url: '<?= base_url('admin/journals/') ?>' + id + '/delete-cover',
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                document.getElementById('currentCover').remove();
                document.getElementById('coverHidden').value = '';
                Toastify({
                    text: 'Portada eliminada',
                    duration: 2000,
                    gravity: 'bottom',
                    position: 'center',
                    style: { background: 'linear-gradient(to right, #00b09b, #96c93d)' }
                }).showToast();
            } else {
                Toastify({
                    text: data.message || 'Error al eliminar la portada',
                    duration: 3000,
                    gravity: 'bottom',
                    position: 'center',
                    style: { background: 'linear-gradient(to right, #ff0048, #ce2124)' }
                }).showToast();
            }
        },
        error: function() {
            Toastify({ text: 'Error de conexión', duration: 3000, gravity: 'bottom', position: 'center',
                style: { background: 'linear-gradient(to right, #ff0048, #ce2124)' } }).showToast();
        }
    });
}
</script>
