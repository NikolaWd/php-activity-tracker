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
        <?php if(!auth()): ?>
        <li>
          <a href="<?= route('login') ?>" class="nav-link <?= $currentPath === route('login') ? 'active' : '' ?>">Login</a>
        </li>
        <li>
          <a href="<?= route('register') ?>" class="nav-link <?= $currentPath === route('register') ? 'active' : '' ?>">Register</a>
        </li>
        <?php else: ?>
          <div style="width: fit-content; margin-right: auto; display:flex; margin-top: 8px; margin-left: 5px;">
            <div style="color: white;">Welcome: <?= auth()->getName() ?> | </div>
            <div style="color: white;">Email: <?= auth()->getEmail() ?> | </div>
            <div style="color: white;">Role: <?= htmlspecialchars(auth()->getRole()->name, ENT_QUOTES, 'UTF-8') ?></div>
          </div>
        <?php endif; ?>
      </ul>
    </div>
    <div>
      <form action="" method="post">
        <input
          hidden
          name="csrf_token"
          value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
        />
        <button type="submit">Logout</button>
      </form>
    </div>
  </div>
</nav>