<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/nav.php'; ?>

<h1>Page B</h1>

<form method="post" action="<?= e(route('page-b.download')) ?>">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <button class="btn btn-primary" type="submit">Download</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
