<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */
/** @var array $characters */

$view->setLayout('root');
?>



<div class="d-flex justify-content-center mb-3">
    <a href="<?= $link->url('add') ?>" class="add-ent-btn">
        Add New Character
    </a>
</div>

<div class="container-xl my-4">
    <div class="row g-4 justify-content-center">
        <?php foreach ($characters as $character): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <a href="<?= $link->url('character', ['id' => $character->getId()]) ?>" class="text-decoration-none text-dark">
                    <div class="home-ind-char-card">
                        <div class="home-ind-char-name">
                            <?= $character->getName() ?>
                        </div>

                        <div class="home-ind-char-img d-flex justify-content-center align-items-center">
                            <img
                                    src="<?= $link->asset($character->getImageUrl()) ?>"
                                    alt="Image of <?= $character->getName() ?>"
                            >
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>