<?php $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/'; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a
                class="nav-link <?= $currentPath === route('home') ? 'active' : '' ?>"
                href="<?= route('home') ?>"
            >Home
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $currentPath === route('users') ? 'active' : '' ?>" href="<?= route('users') ?>">Users</a>
        </li>
        <li>
          <a href="<?= route('login') ?>" class="nav-link">Login</a>
        </li>
        <li>
          <a href="<?= route('register') ?>" class="nav-link">Register</a>
        </li>
      </ul>
    </div>
  </div>
</nav>