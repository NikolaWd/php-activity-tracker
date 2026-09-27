<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/nav.php'; ?>

<h1>
    Login page
    <?= e($pageTitle) ?>
</h1>
<p>This is the login page of our web application.</p>

<?php if ($error !== null): ?>
    <p role="alert" style="color: red;"><?= e($error) ?></p>
<?php endif; ?>

<form method="post" action="<?= e(route('login.post')) ?>">
    <input 
        hidden
        value="<?= e(csrf_token()) ?>"
        name="csrf_token"
    />
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" value="<?= e($email) ?>" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
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
