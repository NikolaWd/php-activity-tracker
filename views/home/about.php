<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/nav.php'; ?>

<main>
    <h1>
        O nama
        <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
    </h1>
    <p>Ovo je stranica o nama.</p>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>