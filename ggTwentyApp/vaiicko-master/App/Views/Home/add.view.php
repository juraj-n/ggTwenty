<?php
    /** @var string|null $message */
    /** @var \Framework\Support\LinkGenerator $link */
    /** @var \Framework\Support\View $view */

    $view->setLayout('root');
?>

<script src="<?= $link->asset('js/changeAddedImage.js') ?>" defer></script> <!-- defer loads script after html -->

<div class="char-card">
    <h2 class="char-form-heading text-center">
        CREATE NEW CHARACTER
    </h2>

    <form method="post" action="<?= $link->url('add') ?>" enctype="multipart/form-data">

        <div class="row">
            <!-- Image Picker -->
            <div class="col-sm-6 mb-4 mb-sm-0">
                <label class="d-block text-white text-center mb-2">Character Image</label>

                <div class="show-image-area mb-3" id="image-area">
                    <img src="" id="image-preview" alt="Character Image Preview">

                    <div class="image-placeholder-content" id="placeholder-text">
                    </div>
                </div>

                <input name="character-img" type="file" id="image-upload" class="form-control image-file-input" accept="image/*">
            </div>
            <!-- Character Info -->
            <div class="col-sm-6">
                <!-- Name -->
                <label for="character-name" class="d-block text-white text-center mb-2">Character Name</label>
                <input name="character-name" type="text" id="character-name" class="form-control custom-input mb-3" placeholder="Enter Character Name" required>

                <hr class="section-separator mb-3">

                <!-- HP / AC -->
                <div class="row g-3 mt-4">
                    <div class="col-6">
                        <label for="character-hp" class="d-block text-white text-center mb-2">Hit Points</label>
                        <input name="character-hp" type="number" id="character-hp" class="form-control" value="0" min="0" required>
                    </div>
                    <div class="col-6">
                        <label for="character-ac" class="d-block text-white text-center mb-2">Armor Class</label>
                        <input name="character-ac" type="number" id="character-ac" class="form-control" value="0" min="0" required>
                    </div>
                </div>
            </div>
        </div>
        <!-- Save Button -->
        <div class="d-flex justify-content-center">
            <button type="submit" name="submit" class="btn add-save-btn">Save New Character</button>
        </div>
    </form>

    <!-- Message Box for feedback (instead of alert()) -->
    <div id="message-box" class="mt-3 alert d-none" role="alert"></div>

</div>