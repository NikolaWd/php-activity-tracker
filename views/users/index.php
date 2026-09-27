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

    <?php if ($totalPages > 1): ?>
        <nav aria-label="User pages">
            <ul class="pagination">
                <li class="page-item <?= $page === 1 ? 'disabled' : '' ?>">
                    <?php if ($page > 1): ?>
                        <a class="page-link" href="<?= e(route('users') . '?page=' . ($page - 1)) ?>" aria-label="Previous">&laquo;</a>
                    <?php else: ?>
                        <span class="page-link" aria-label="Previous">&laquo;</span>
                    <?php endif; ?>
                </li>

                <?php for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++): ?>
                    <li class="page-item <?= $pageNumber === $page ? 'active' : '' ?>">
                        <a class="page-link" href="<?= e(route('users') . '?page=' . $pageNumber) ?>"
                           <?= $pageNumber === $page ? 'aria-current="page"' : '' ?>><?= e($pageNumber) ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $page === $totalPages ? 'disabled' : '' ?>">
                    <?php if ($page < $totalPages): ?>
                        <a class="page-link" href="<?= e(route('users') . '?page=' . ($page + 1)) ?>" aria-label="Next">&raquo;</a>
                    <?php else: ?>
                        <span class="page-link" aria-label="Next">&raquo;</span>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
    

<?php require __DIR__ . '/../layout/footer.php'; ?>
