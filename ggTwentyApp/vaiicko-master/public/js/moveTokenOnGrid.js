document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('mainGrid');
    let selectedToken = null;
    // OnCLick Select
    grid.querySelectorAll('.token-on-grid').forEach(token => {
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
        // Unselect token
        selectedToken.style.border = 'none';
        selectedToken = null;

        // TODO: AJAX
        // Optional: AJAX call to save new x,y in DB
        // Example:
        // fetch('/encounters/moveToken', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify({ id: selectedToken.dataset.tokenId, x, y })
        // });
    });
});
