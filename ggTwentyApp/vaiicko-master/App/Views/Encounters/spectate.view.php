<?php
use App\Models\Encounter;
/** @var \Framework\Support\LinkGenerator $link */
/** @var Encounter $encounter */
/** @var array $tokens */
/** @var string $dmName */

?>
<script defer> const ENC_ID = <?= (int)$encounter->getId() ?>; </script>
<script src="<?= $link->asset('js/spectatePoll.js') ?>" defer></script>

<div class="enc-view container-fluid">
    <div class="row justify-content-center align-items-stretch g-3">
        <!-- Grid Map -->
        <div class="col-12 col-md-8 col-lg-6 d-flex justify-content-center">
            <div class="enc-map-wrapper h-100">
                <div class="enc-map" id="mainGrid">
                    <!-- Grid Tokens -->
                    <?php foreach($tokens as $token): ?>
                        <img
                                src="<?= $token->getImageUrl() ?>" alt="<?= $token->getName() ?>"
                                class="enc-map-token"
                                data-token-id="<?= $token->getId() ?>"
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
            <div class="enc-info-wrapper h-100">
                <!-- Top Bar -->
                <div class="enc-info-topbar d-flex w-100 mb-3">
                    <!-- Code -->
                    <div class="enc-info-code flex-grow-1">
                        CODE: <?= $encounter->getCode() ?>
                    </div>
                    <!-- DM Name -->
                    <div class="enc-info-code">
                        DM: <?= $dmName ?>
                    </div>
                </div>
                <!-- Token On Round -->
                <?php if (count($tokens) > 0): ?>
                    <div class="d-flex justify-content-center">
                        <div class="enc-on-round-token d-inline-flex flex-column align-items-center">
                            <img src="<?= $tokens[$encounter->getCurrent()]->getImageUrl() ?>"
                                 alt="<?= $tokens[$encounter->getCurrent()]->getName() ?>"
                                 class="enc-on-round-img">
                            <div class="enc-on-round-name">
                                (#<?= $tokens[$encounter->getCurrent()]->getId() ?>)
                                <?= $tokens[$encounter->getCurrent()]->getName() ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Token Info -->
                <div class="enc-info-token flex-grow-1 overflow-auto">
                    <?php foreach($tokens as $token): ?>
                        <div class="enc-info-token-card d-flex align-items-center mb-2">
                            <!-- Image -->
                            <img src="<?= $token->getImageUrl() ?>" alt="<?= $token->getName() ?>"
                                 class="enc-info-token-img">
                            <!-- Name -->
                            <span class="enc-info-token-name flex-grow-1 ms-2">
                                (#<?= $token->getId() ?>) <?= $token->getName() ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>