<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/nav.php'; ?>

    <h1>
        Welcome to User page
        <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
    </h1>
    <p>This is a index page for users.</p>

    <?php if (count($users) < 1) : ?>
        <p style="color: red;">There is no users in our system....</p>
    <?php else: ?>
        <table>
            <thead>
                <th>Index</th>
                <th>Name</th>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['name'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    

<?php require __DIR__ . '/../layout/footer.php'; ?>
