<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/nav.php'; ?>

<h1>Activity statistics</h1>

<form method="get" action="<?= e(route('statistics')) ?>" class="row g-3 mb-4">
    <div class="col-md-2">
        <label for="date_from" class="form-label">From</label>
        <input class="form-control" type="date" id="date_from" name="date_from" value="<?= e($dateFrom) ?>">
    </div>
    <div class="col-md-2">
        <label for="date_to" class="form-label">To</label>
        <input class="form-control" type="date" id="date_to" name="date_to" value="<?= e($dateTo) ?>">
    </div>
    <div class="col-md-3">
        <label for="user_id" class="form-label">User</label>
        <select class="form-select" id="user_id" name="user_id">
            <option value="">All users</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= e($user->getId()) ?>" <?= (string) $user->getId() === $userId ? 'selected' : '' ?>>
                    <?= e($user->getName()) ?> (<?= e($user->getEmail()) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <label for="action" class="form-label">Action</label>
        <select class="form-select" id="action" name="action">
            <option value="">All actions</option>
            <?php foreach ($actions as $option): ?>
                <option value="<?= e($option->value) ?>" <?= $option->value === $action ? 'selected' : '' ?>><?= e($option->value) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2 align-self-end">
        <button class="btn btn-primary" type="submit">Filter</button>
        <a class="btn btn-outline-secondary" href="<?= e(route('statistics')) ?>">Clear</a>
    </div>
</form>

<?php if ($events === []): ?>
    <p>No events found.</p>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead><tr><th>Date</th><th>User</th><th>Email</th><th>Action</th><th>Target</th></tr></thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= e($event['created_at']) ?></td>
                        <td><?= e($event['name']) ?></td>
                        <td><?= e($event['email']) ?></td>
                        <td><?= e($event['action']) ?></td>
                        <td><?= e($event['target'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
