<?php
use App\Models\Encounter;

/** @var Encounter $encounter */
/** @var array $tokens */


?>

<div class="enc-view container-fluid">
    <div class="row justify-content-center align-items-stretch g-3">

        <!-- Grid Map -->
        <div class="col-12 col-md-8 col-lg-6 d-flex justify-content-center">
            <div class="map-grid-wrapper h-100">
                <div class="map-grid" id="mainGrid">
                    <!-- Tokens -->
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
                <!-- Tokens -->
                <div>
                    TOKENS
                </div>
                <!-- End Round -->
                <a href="#" class="end-round-btn">
                    End Round
                </a>
            </div>
        </div>

    </div>
</div>