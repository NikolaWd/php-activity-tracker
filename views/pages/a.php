<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/nav.php'; ?>

<h1>Page A</h1>

<?php if ($hasPurchased): ?>
    <p role="status">thankYou</p>
<?php else: ?>
    <form method="post" action="<?= e(route('page-a.buy')) ?>">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <button class="btn btn-primary" type="submit">Buy a cow</button>
    </form>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
