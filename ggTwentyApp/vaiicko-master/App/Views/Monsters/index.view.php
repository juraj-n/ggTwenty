<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */
/** @var array $monsters */

use App\Configuration;

$view->setLayout('root');
?>

<div class="add-char">
    <a href="<?= $link->url('add') ?>" class="add-char-btn">
        Add New Monster
    </a>
</div>

<div class="container my-4 character-card-grid">
    <div class="row g-4 justify-content-center">
        <?php foreach ($monsters as $monster): ?>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card monster-card border-0 position-relative h-100">
                    <div class="row g-0 h-100">
                        <!-- Image -->
                        <div class="col-4">
                            <img
                                src="<?= $link->asset($monster->getImageUrl()) ?>"
                                class="img-fluid rounded monster-img"
                                alt="<?= htmlspecialchars($monster->getName()) ?>"
                            >
                        </div>
                        <!-- Monster Info -->
                        <div class="col-8 d-flex align-items-center justify-content-center text-center">
                            <div class="card-body px-2">
                                <div class="monster-info">
                                    <h5 class="monster-name-text mb-0"><?= htmlspecialchars($monster->getName()) ?></h5>
                                    <span class="hp-text"><?= $monster->getHp() ?>❤️</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="position-absolute top-0 end-0 p-1">
                        <form method="post" action="<?= $link->url('delete') ?>" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="id" value="<?= $monster->getId() ?>">
                            <button type="submit" class="delete-monst-btn">
                                X
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
