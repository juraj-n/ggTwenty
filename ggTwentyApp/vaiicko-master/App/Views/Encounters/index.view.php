<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('root');
?>

<div class="enc-options d-flex flex-column align-items-center p-4 mx-auto">
    <!-- Join Form -->
    <form class="d-flex w-100 mb-2 form-wrapper">
        <input type="text" name="code" class="join-enc-inp" placeholder="Code" required>
        <button type="submit" class="join-enc-btn">Join</button>
    </form>
    <!-- Create Button -->
    <a href="<?= $link->url('encounter') ?>" class="create-enc-btn">
        Become DM
    </a>
</div>
