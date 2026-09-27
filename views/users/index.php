<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/nav.php'; ?>

    <h1>
        Welcome to User page
        <?= e($pageTitle) ?>
    </h1>
    <p>This is a index page for users.</p>

    <?php if (count($users) < 1) : ?>
        <p style="color: red;">There is no users in our system....</p>
    <?php else: ?>
        <table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <th scope="row"><?= e($user->getId()) ?></th>
                <td><?= e($user->getName()) ?></td>
                <td><?= e($user->getEmail()) ?></td>
                <td><?= e($user->getRole()->name) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    <?php endif; ?>
    

<?php require __DIR__ . '/../layout/footer.php'; ?>
