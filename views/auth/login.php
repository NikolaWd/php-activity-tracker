<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/nav.php'; ?>

<h1>
    Login page
    <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
</h1>
<p>Ovo je login stranica naše web aplikacije.</p>

<?php if ($error !== null): ?>
    <p role="alert" style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<form method="post" action="<?= route('login.post'); ?>">
    <input 
        hidden
        value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"
        name="csrf_token"
    />
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="remember_me" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Remember me</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>