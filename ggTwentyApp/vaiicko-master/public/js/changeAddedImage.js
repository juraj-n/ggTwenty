document.getElementById('image-upload').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('placeholder-text');

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };

        reader.readAsDataURL(file);
    } else {
        preview.src = "";
        preview.style.display = 'none';
        placeholder.style.display = 'block';
    }
});