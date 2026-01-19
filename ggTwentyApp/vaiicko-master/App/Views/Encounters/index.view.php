<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('root');
?>

<div class="enc-ind-options d-flex flex-column align-items-center p-4 mx-auto">
    <!-- Join Form -->
    <form  method="post" action="<?= $link->url('spectate') ?>"
           class="enc-ind-form-join d-flex mb-2" id="joinForm">
        <input type="text" name="code" id="encounterCodeInput" class="enc-ind-join-inp flex-fill p-2" placeholder="Code" required>
        <button type="submit" class="enc-ind-join-btn flex-fill p-2">
            Join
        </button>
    </form>
    <!-- Create Button -->
    <a href="<?= $link->url('encounter') ?>" class="enc-ind-dm-btn">
        Become DM
    </a>
</div>