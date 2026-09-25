<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/nav.php'; ?>

<main>
    <h1>
        Dobrodošli na našu početnu stranicu!
        <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
    </h1>
    <p>Ovo je početna stranica naše web aplikacije.</p>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>
