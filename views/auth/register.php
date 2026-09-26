<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/nav.php'; ?>

    <h1>
        Register page
        <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
    </h1>
    <p>Ovo je Register stranica naše web aplikacije.</p>

    <form>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="name" name="name" class="form-control" id="name" aria-describedby="name">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="password1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password1">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Password Confriamtion</label>
            <input type="password_confirmation" name="password_confirmation" class="form-control" id="password_confirmation">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<?php require __DIR__ . '/../layout/footer.php'; ?>