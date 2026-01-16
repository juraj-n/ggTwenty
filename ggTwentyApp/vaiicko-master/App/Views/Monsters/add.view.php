<?php
/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('root');
?>

<script src="<?= $link->asset('js/changeAddedImage.js') ?>" defer></script> <!-- defer loads script after html -->

<div class="char-card">
    <h2 class="char-form-heading text-center">
        CREATE NEW MONSTER
    </h2>

    <form method="post" action="<?= $link->url('add') ?>" enctype="multipart/form-data">

        <div class="row">
            <!-- Image Picker -->
            <div class="col-sm-6 mb-4 mb-sm-0">
                <label class="d-block text-white text-center mb-2">Monster Image</label>
                <div class="show-image-area mb-3" id="image-area">
                    <img src="" id="image-preview" alt="Monster Image Preview">
                    <div class="image-placeholder-content" id="placeholder-text">
                    </div>
                </div>
                <input name="monster-img" type="file" id="image-upload" class="form-control image-file-input" accept="image/*">
            </div>
            <!-- Character Info -->
            <div class="col-sm-6">
                <!-- Name -->
                <label for="monster-name" class="d-block text-white text-center mb-2">Monster Name</label>
                <input name="monster-name" type="text" id="monster-name" class="form-control custom-input mb-3" placeholder="Enter Monster Name" required>

                <hr class="section-separator mb-3">
                <!-- HP -->
                <div class="row g-3 mt-4">
                    <div class="col-6">
                        <label for="monster-hp" class="d-block text-white text-center mb-2">Hit Points</label>
                        <input name="monster-hp" type="number" id="monster-hp" class="form-control" value="0" min="0" required>
                    </div>
                </div>
            </div>
        </div>
        <!-- Save Button -->
        <div class="d-flex justify-content-center">
            <button type="submit" name="submit" class="btn add-save-btn">Save New Monster</button>
        </div>
    </form>

    <!-- Message Box for feedback (instead of alert()) -->
    <div id="message-box" class="mt-3 alert d-none" role="alert"></div>

    <p>
        <?= $message ?? '' ?>
    </p>

</div>