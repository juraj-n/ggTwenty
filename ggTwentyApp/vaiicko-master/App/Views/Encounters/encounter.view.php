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
                    <a href="#" class="top-btn del-btn ms-2">
                        Delete
                    </a>
                </div>
                <!-- Token Info -->
                <div class="tokens flex-grow-1 overflow-auto">
                    <?php foreach($tokens as $token): ?>
                        <div class="token-card d-flex align-items-center mb-2">
                            <!-- Image -->
                            <img src="<?= $token->getImageUrl() ?>" alt="<?= $token->getName() ?>" class="token-img">
                            <!-- Name -->
                            <span class="token-name flex-grow-1 ms-2">
                                <?= $token->getName() ?>
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
                <a href="#" class="end-round-btn">
                    End Round
                </a>
            </div>
        </div>

    </div>
</div>