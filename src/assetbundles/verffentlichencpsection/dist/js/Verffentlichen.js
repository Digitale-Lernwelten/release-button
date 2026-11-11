(() => {
    const init = () => {
        const button = document.getElementById('release-button');
        if (!button || button.dataset.configured !== '1') {
            return;
        }

        const status = document.getElementById('release-status');
        const hello = document.getElementById('release-hello');
        const waiting = document.getElementById('release-waiting');
        const done = document.getElementById('release-done');

        button.addEventListener('click', async () => {
            button.disabled = true;
            status.textContent = 'Veröffentlichung wird gestartet …';
            hello.hidden = true;
            waiting.hidden = false;

            try {
                const response = await Craft.sendActionRequest('POST', 'release/deploy/index');
                if (!response.data.deployment) {
                    throw new Error(response.data.error || 'Die Veröffentlichung ist fehlgeschlagen.');
                }

                waiting.hidden = true;
                done.hidden = false;
                done.play();
                status.textContent = 'Veröffentlichung gestartet.';
            } catch (error) {
                waiting.hidden = true;
                hello.hidden = false;
                status.textContent = error.response?.data?.error || error.message || 'Die Veröffentlichung ist fehlgeschlagen.';
                button.disabled = false;
            }
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
