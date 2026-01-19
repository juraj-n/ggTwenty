<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */
/** @var array $monsters */

$view->setLayout('root');
?>

<div class="d-flex justify-content-center mb-3">
    <a href="<?= $link->url('add') ?>" class="add-ent-btn">
        Add New Monster
    </a>
</div>

<div class="container-xl my-4">
    <div class="row g-4 justify-content-center">
        <?php foreach ($monsters as $monster): ?>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="monst-ind-card position-relative">
                    <div class="row g-0 h-100">
                        <!-- Image -->
                        <div class="col-4">
                            <img
                                src="<?= $link->asset($monster->getImageUrl()) ?>"
                                alt="<?= htmlspecialchars($monster->getName()) ?>"
                                class="monst-ind-img"
                            >
                        </div>
                        <!-- Monster Info -->
                        <div class="col-8 d-flex align-items-center justify-content-center text-center">
                            <div class="card-body px-2">
                                <div class="monst-ind-info">
                                    <h5 class="monst-ind-name mb-0"><?= htmlspecialchars($monster->getName()) ?></h5>
                                    <span class="hp-text"><?= $monster->getHp() ?>❤️</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="position-absolute top-0 end-0 p-1">
                        <form method="post" action="<?= $link->url('delete') ?>" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="id" value="<?= $monster->getId() ?>">
                            <button type="submit" class="monst-ind-del-btn">
                                X
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
