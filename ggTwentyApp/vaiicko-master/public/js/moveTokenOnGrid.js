document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('mainGrid');
    let selectedToken = null;
    // Initial Positioning
    grid.querySelectorAll('.enc-map-token').forEach(token => {
        const x = parseFloat(token.dataset.x);
        const y = parseFloat(token.dataset.y);
        if (!isNaN(x) && !isNaN(y)) {
            token.style.left = `${6.7 + x * (100 / 8.5)}%`;
            token.style.top  = `${6.7 + y * (100 / 8.5)}%`;
        }
    });
    // OnCLick Select
    grid.querySelectorAll('.enc-map-token').forEach(token => {
        token.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent grid click from triggering
            if (selectedToken) {
                selectedToken.style.border = 'none';
            }
            selectedToken = token;
            selectedToken.style.border = '2px solid white';
        });
    });
    // OnSecondClick Move
    grid.addEventListener('click', (e) => {
        if (!selectedToken)
            return;
        const rect = grid.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const clickY = e.clientY - rect.top;

        const cellWidth = rect.width / 8;
        const cellHeight = rect.height / 8;
        // X, Y (0-7)
        const x = Math.floor(clickX / cellWidth);
        const y = Math.floor(clickY / cellHeight);
        // Update Position
        selectedToken.style.left = `${6.7 + x * (100 / 8.5)}%`;
        selectedToken.style.top  = `${6.7 + y * (100 / 8.5)}%`;

        void savePosition(selectedToken.dataset.tokenId, x, y); // Void to ignore promise

        // Unselect token
        selectedToken.style.border = 'none';
        selectedToken = null;


    });
});

async function savePosition(tokenId, x, y) {
    try {
        const response = await fetch(window.changeTokenPositionUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ token_id: tokenId, x, y })
        });
        const data = await response.json();
        if (!data.success)
            console.error('Move failed:', data.error);
    } catch (err) {
        console.error('AJAX error:', err);
    }
}