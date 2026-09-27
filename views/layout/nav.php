<?php

use App\Enums\UserRole;

 $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/'; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a
                class="nav-link <?= $currentPath === route('home') ? 'active' : '' ?>"
                href="<?= e(route('home')) ?>"
            >Home
            </a>
        </li>
        <?php if(auth() && auth()->getRole() === UserRole::Admin): ?>
          <li class="nav-item">
            <a class="nav-link <?= $currentPath === route('users') ? 'active' : '' ?>" href="<?= e(route('users')) ?>">Users</a>
          </li>
        <?php endif; ?>
        <?php if(!auth()): ?>
        <li>
          <a href="<?= e(route('login')) ?>" class="nav-link <?= $currentPath === route('login') ? 'active' : '' ?>">Login</a>
        </li>
        <li>
          <a href="<?= e(route('register')) ?>" class="nav-link <?= $currentPath === route('register') ? 'active' : '' ?>">Register</a>
        </li>
        <?php else: ?>
          <div style="width: fit-content; margin-right: auto; display:flex; margin-top: 8px; margin-left: 5px; background: white; color: black;" class="p-2">
            <div>Welcome: <?= e(auth()->getName()) ?> | </div>
            <div>Email: <?= e(auth()->getEmail()) ?> | </div>
            <div>Role: <?= e(auth()->getRole()->name) ?></div>
          </div>
        <?php endif; ?>
      </ul>
    </div>
    <?php if(auth()): ?>
    <div>
      <form action="<?= e(route('logout')) ?>" method="post">
        <input
          hidden
          name="csrf_token"
          value="<?= e(csrf_token()) ?>"
        />
        <button type="submit">Logout</button>
      </form>
    </div>
    <?php endif; ?>
  </div>
</nav>
