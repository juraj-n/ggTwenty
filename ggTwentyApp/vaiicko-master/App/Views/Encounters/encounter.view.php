<?php
use App\Models\Encounter;
/** @var \Framework\Support\LinkGenerator $link */
/** @var Encounter $encounter */
/** @var array $tokens */


?>
<script src="<?= $link->asset('js/moveTokenOnGrid.js') ?>" defer></script>

<div class="enc-view container-fluid">
    <div class="row justify-content-center align-items-stretch g-3">

        <!-- Grid Map -->
        <div class="col-12 col-md-8 col-lg-6 d-flex justify-content-center">
            <div class="map-grid-wrapper h-100">
                <div class="map-grid" id="mainGrid">
                    <!-- Grid Tokens -->
                    <?php foreach($tokens as $token): ?>
                        <img
                                src="<?= $token->getImageUrl() ?>" alt="<?= $token->getName() ?>"
                                class="token-on-grid"
                                style="
                                        top: <?= 6.7 + $token->getY() * (100 / 8.5) ?>%;
                                        left: <?= 6.7 + $token->getX() * (100 / 8.5) ?>%;
                                        "
                        >
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
            <div class="info-panel-wrapper h-100">
                <!-- Top Bar -->
                <div class="top-bar d-flex w-100 mb-3">
                    <!-- Code -->
                    <div class="top-code flex-grow-1">
                        CODE: <?= $encounter->getCode() ?>
                    </div>
                    <!-- Add button -->
                    <a href="#" class="top-btn add-btn ms-2">
                        Add
                    </a>
                    <!-- Delete button -->
                    <form method="post" action="<?= $link->url('encounters.deleteEncounter') ?>">
                        <input type="hidden" name="id" value="<?= $encounter->getId() ?>">
                        <button type="submit" class="top-btn del-btn ms-2">
                            Delete
                        </button>
                    </form>
                </div>
                <!-- Token On Round -->
                <?php if (count($tokens) > 0): ?>
                <div class="d-flex justify-content-center">
                    <div class="on-round-card d-inline-flex flex-column align-items-center">
                        <img src="<?= $tokens[$encounter->getCurrent()]->getImageUrl() ?>"
                             alt="<?= $tokens[$encounter->getCurrent()]->getName() ?>"
                             class="on-round-img">
                        <div class="on-round-name">
                            (#<?= $tokens[$encounter->getCurrent()]->getId() ?>) <?= $tokens[$encounter->getCurrent()]->getName() ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <!-- Token Info -->
                <div class="tokens flex-grow-1 overflow-auto">
                    <?php foreach($tokens as $token): ?>
                        <div class="token-card d-flex align-items-center mb-2">
                            <!-- Image -->
                            <img src="<?= $token->getImageUrl() ?>" alt="<?= $token->getName() ?>" class="token-img">
                            <!-- Name -->
                            <span class="token-name flex-grow-1 ms-2">
                                (#<?= $token->getId() ?>) <?= $token->getName() ?>
                            </span>
                            <!-- Delete Token -->
                            <form method="post" action="<?= $link->url('encounters.deleteToken') ?>">
                                <input type="hidden" name="id" value="<?= $token->getId() ?>">
                                <button type="submit" class="token-del-btn ms-2">
                                    X
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- End Round -->
                <form method="post" action="<?= $link->url('encounters.endRound') ?>" class="d-flex justify-content-center w-100 mt-auto">
                    <input type="hidden" name="id" value="<?= $encounter->getId() ?>">
                    <button type="submit" class="end-round-btn ms-2">
                        End Round
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>