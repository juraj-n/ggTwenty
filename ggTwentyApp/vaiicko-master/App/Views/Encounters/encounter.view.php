<?php
use App\Models\Encounter;
/** @var \Framework\Support\LinkGenerator $link */
/** @var Encounter $encounter */
/** @var array $tokens */
/** @var array $dmchars */
/** @var array $dmmonsters */


?>
<script>window.changeTokenPositionUrl = "<?= $link->url('encounters.changeTokenPosition') ?>";</script> <!-- For AJAX position handling -->
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
            <div class="info-panel-wrapper h-100">
                <!-- Top Bar -->
                <div class="top-bar d-flex w-100 mb-3">
                    <!-- Code -->
                    <div class="top-code flex-grow-1">
                        CODE: <?= $encounter->getCode() ?>
                    </div>
                    <!-- Add button -->
                    <button type="button" class="top-btn add-btn ms-2" data-bs-toggle="modal" data-bs-target="#addOptionsModal">
                        Add
                    </button>
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

<!-- When ADD Button is called -->
<div class="modal" id="addOptionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark shadow-lg">
            <div class="modal-body p-0">
                <div class="list-group list-group-flush">
                    <?php foreach($dmmonsters as $monster): ?>
                        <form method="post" action="<?= $link->url('encounters.addMonster') ?>"
                              class="list-group-item bg-dark border-secondary d-flex align-items-center">
                            <input type="hidden" name="encounter_id" value="<?= $encounter->getId() ?>">
                            <input type="hidden" name="id" value="<?= $monster->getId() ?>">

                            <img src="<?= $monster->getImageUrl() ?>" alt="<?= $monster->getName() ?>" class="add-img me-2">
                            <div class="flex-grow-1 text-white">
                                <?= $monster->getName() ?>
                            </div>
                            <div class="input-group input-group-sm add-initiative">
                                <span class="input-group-text bg-secondary text-white border-secondary">Init:</span>
                                <input type="number" name="initiative"
                                       class="form-control bg-dark text-white border-secondary text-center"
                                       placeholder="0" required min="0" max="50">
                                <button type="submit" class="top-btn add-btn">
                                    Add
                                </button>
                            </div>
                        </form>
                    <?php endforeach; ?>

                    <?php foreach($dmchars as $char): ?>
                        <form method="post" action="<?= $link->url('encounters.addCharacter') ?>"
                              class="list-group-item bg-dark border-secondary d-flex align-items-center">
                            <input type="hidden" name="encounter_id" value="<?= $encounter->getId() ?>">
                            <input type="hidden" name="id" value="<?= $char->getId() ?>">

                            <img src="<?= $char->getImageUrl() ?>" alt="<?= $char->getName() ?>"
                                 class="add-img me-2">

                            <div class="flex-grow-1 text-white">
                                <?= $char->getName() ?>
                            </div>

                            <div class="input-group input-group-sm add-initiative">
                                <span class="input-group-text bg-secondary text-white border-secondary">Init:</span>
                                <input type="number" name="initiative"
                                       class="form-control bg-dark text-white border-secondary text-center"
                                       placeholder="0" required>
                                <button type="submit" class="top-btn add-btn">
                                    Add
                                </button>
                            </div>
                        </form>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>