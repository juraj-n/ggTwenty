<?php

/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('auth');
?>

<!-- Log In Button -->
<a href="<?= $link->url('login.index') ?>" class="top-btn">Log In</a>

<!-- Sign In Card -->
<div class="container d-flex justify-content-center">
    <div class="card my-5 card-auth">
        <div class="card-body">

            <!-- Logo -->
            <div class="text-center mb-3">
                <img src="<?= $link->asset("images/gg_logo.png") ?>" alt="Logo" class="img-fluid logo-auth">
            </div>

            <!-- Validation Error messages -->
            <div class="text-center text-danger mb-3">
                <?= @$message ?>
            </div>

            <!-- Forms -->
            <form method="post" action="<?= $link->url('signin') ?>">
                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input name="username" type="text" id="username" class="form-control" placeholder="Username"
                           required autofocus>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" id="password" class="form-control"
                           placeholder="Password" required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <input name="confirm-password" type="password" id="confirm-password" class="form-control"
                           placeholder="Password" required>
                </div>

                <!-- Accept Button -->
                <button type="submit" name="submit" class="btn auth-accept">
                    Sign In
                </button>
            </form>

        </div>
    </div>
</div>
