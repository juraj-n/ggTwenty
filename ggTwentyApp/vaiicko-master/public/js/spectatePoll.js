const POLL_INTERVAL = 2000;

async function fetchSpectateData() {
    try {
        const response = await fetch(`/?c=encounters&a=spectateData&enc_id=${ENC_ID}`);
        if (!response.ok) return;

        const data = await response.json();

        // Make sure we have tokens and current
        if (!data.tokens || !Array.isArray(data.tokens) || typeof data.current !== 'number') return;

        updateGrid(data.tokens);
        updateCurrentToken(data.tokens, data.current);
        updateTokenList(data.tokens);

    } catch (e) {
        console.error('Polling failed', e);
    }
}

// Initial fetch immediately
fetchSpectateData();

// Then poll repeatedly
setInterval(fetchSpectateData, POLL_INTERVAL);

// --- DOM Update Functions ---

function updateGrid(tokens) {
    const grid = document.getElementById('mainGrid');
    if (!grid) return;

    // Remove old tokens
    grid.querySelectorAll('.enc-map-token').forEach(t => t.remove());

    // Add current tokens
    tokens.forEach(token => {
        const img = document.createElement('img');
        img.src = token.img;
        img.alt = token.name;
        img.className = 'enc-map-token';
        img.dataset.tokenId = token.id;

        img.style.top = `${6.7 + token.y * (100 / 8.5)}%`;
        img.style.left = `${6.7 + token.x * (100 / 8.5)}%`;

        grid.appendChild(img);
    });
}

function updateCurrentToken(tokens, currentIndex) {
    if (!tokens.length) return;

    const card = document.querySelector('.enc-on-round-token');
    if (!card) return;

    const token = tokens[currentIndex];
    if (!token) return;

    const imgElem = card.querySelector('.enc-on-round-img');
    const nameElem = card.querySelector('.enc-on-round-name');

    if (imgElem) imgElem.src = token.img;
    if (nameElem) nameElem.textContent = `(#${token.id}) ${token.name}`;
}

function updateTokenList(tokens) {
    const list = document.querySelector('.enc-info-token');
    if (!list) return;

    list.innerHTML = '';

    tokens.forEach(token => {
        list.insertAdjacentHTML('beforeend', `
            <div class="enc-info-token-card d-flex align-items-center mb-2">
                <img src="${token.img}" class="enc-info-token-img">
                <span class="flex-grow-1 ms-2">
                    (#${token.id}) ${token.name}
                </span>
            </div>
        `);
    });
}