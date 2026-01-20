document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('edit-character-form');
    const inputs = form.querySelectorAll('input[type="text"], input[type="number"], input[type="file"]');
    const messageBox = document.getElementById('message-box');

    function showFeedback(message, type = 'success') {
        messageBox.textContent = message;
        messageBox.className = `mt-3 alert alert-${type}`;
        messageBox.classList.remove('d-none');
        setTimeout(() => {
            messageBox.classList.add('d-none');
        }, 500);
    }

    // AJAX to send data
    function saveCharacterData(inputElement) {
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showFeedback(data.message, 'success');
                    if (data.new_image_url) {
                        document.getElementById('image-preview').src = data.new_image_url;
                    }
                } else if (data.status === 'error') {
                    showFeedback(data.message, 'danger');
                } else {
                    showFeedback('Unexpected server response.', 'warning');
                }
            })
            .catch(error => {
                console.error('Save failed:', error);
                showFeedback('Error saving data.', 'danger');
            });
    }

    // Autosave event listeners
    inputs.forEach(input => {
        if (input.type !== 'file') {
            input.addEventListener('blur', function() {
                saveCharacterData(this);
            });
        }
    });

    const imageUpload = document.getElementById('image-upload');
    imageUpload.addEventListener('change', function() {
        saveCharacterData(this);
    });
});