<?php

use App\Enums\UserRole;

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$currentUser = auth();
?>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid d-flex flex-wrap gap-3">
        <div class="navbar-nav flex-row flex-wrap gap-3">
            <a class="nav-link <?= $currentPath === route('home') ? 'active' : '' ?>" href="<?= e(route('home')) ?>">Home</a>

            <?php if ($currentUser !== null): ?>
                <a class="nav-link <?= $currentPath === route('page-a') ? 'active' : '' ?>" href="<?= e(route('page-a')) ?>">Page A</a>
                <a class="nav-link <?= $currentPath === route('page-b') ? 'active' : '' ?>" href="<?= e(route('page-b')) ?>">Page B</a>
                <a class="nav-link <?= $currentPath === route('reports') ? 'active' : '' ?>" href="<?= e(route('reports')) ?>">Reports</a>

                <?php if ($currentUser->getRole() === UserRole::Admin): ?>
                    <a class="nav-link <?= $currentPath === route('users') ? 'active' : '' ?>" href="<?= e(route('users')) ?>">Users</a>
                    <a class="nav-link <?= $currentPath === route('statistics') ? 'active' : '' ?>" href="<?= e(route('statistics')) ?>">Statistics</a>
                <?php endif; ?>
            <?php else: ?>
                <a class="nav-link <?= $currentPath === route('login') ? 'active' : '' ?>" href="<?= e(route('login')) ?>">Login</a>
                <a class="nav-link <?= $currentPath === route('register') ? 'active' : '' ?>" href="<?= e(route('register')) ?>">Register</a>
            <?php endif; ?>
        </div>

        <?php if ($currentUser !== null): ?>
            <div class="d-flex flex-wrap align-items-center gap-2 text-white">
                <span>Welcome: <?= e($currentUser->getName()) ?> | <?= e($currentUser->getEmail()) ?> | <?= e($currentUser->getRole()->name) ?></span>
                <form action="<?= e(route('logout')) ?>" method="post" class="m-0">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</nav>
