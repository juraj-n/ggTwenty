<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var array $encounter */
/** @var array $characters */
?>

<div class="container mt-5 d-flex flex-column align-items-center">
    <?php foreach ($characters as $char): ?>
        <form method="post" action="<?= $link->url('encounters.spectate') ?>"
              class="character-card d-flex flex-column flex-md-row align-items-center mb-1 w-100">

            <input type="hidden" name="enc_id" value="<?= $encounter[0]->getId() ?>">
            <input type="hidden" name="char_id" value="<?= $char->getId() ?>">

            <!-- Character Image -->
            <img src="<?= $char->getImageUrl() ?>"
                 alt="<?= $char->getName() ?>"
                 class="add-img mb-2 mb-md-0 me-md-3">

            <!-- Character Name -->
            <div class="flex-grow-1 text-white mb-2 mb-md-0 text-center text-md-start">
                <?= htmlspecialchars($char->getName()) ?>
            </div>

            <!-- Initiative + Button -->
            <div class="input-group input-group-sm add-initiative">
                <span class="input-group-text bg-secondary text-white border-secondary">
                    Init:
                </span>
                <input type="number"
                       name="initiative"
                       class="form-control bg-dark text-white border-secondary text-center"
                       placeholder="0"
                       required min="0" max="50">
                <button type="submit" class="top-btn add-btn">
                    Join
                </button>
            </div>
        </form>
    <?php endforeach; ?>
</div>