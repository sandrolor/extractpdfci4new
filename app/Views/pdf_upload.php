<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de PDF</title>
</head>
<body>
    <h2>Upload de Extrato de Folha de Pagamento</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php elseif (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="<?= base_url('upload') ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="pdf_file" required>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>