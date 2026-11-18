(() => {

    const transmission = window.RELAY_TRANSMISSION;

    const receiveButton =
        document.getElementById('receive-button');

    const replayButton =
        document.getElementById('replay-button');

    const signalBar =
        document.getElementById('signal-bar');

    const signalValue =
        document.getElementById('signal-value');

    const signalLabel =
        document.getElementById('signal-label');

    const bootLog =
        document.getElementById('boot-log');

    const messagePanel =
        document.getElementById('message-panel');

    const messageOutput =
        document.getElementById('message-output');

    const footerStatus =
        document.getElementById('footer-status');

    const soundToggle =
        document.getElementById('sound-toggle');


    let running = false;
    let audioContext;


    // Delay helper

    const sleep = ms =>
        new Promise(resolve => setTimeout(resolve, ms));


    // Update terminal clock

    function updateClock() {

        document.getElementById('clock').textContent =
            new Date().toLocaleTimeString(
                'en-GB',
                { hour12: false }
            );

    }

    updateClock();

    setInterval(updateClock, 1000);


    // Optional terminal beep

    function beep() {

        if (!soundToggle.checked) return;

        try {

            audioContext ||= new (
                window.AudioContext ||
                window.webkitAudioContext
            )();

            const oscillator =
                audioContext.createOscillator();

            const gain =
                audioContext.createGain();

            oscillator.type = 'square';

            oscillator.frequency.value = 680;

            gain.gain.value = 0.018;

            oscillator.connect(gain);

            gain.connect(audioContext.destination);

            oscillator.start();

            oscillator.stop(
                audioContext.currentTime + 0.025
            );

        } catch (_) {

            // Audio is optional.
            // The terminal still works without it.

        }

    }


    // Character-by-character typing

    async function typeText(target, text, speed = 24) {

        const p = document.createElement('p');

        target.appendChild(p);

        for (const character of text) {

            p.textContent += character;

            if (character !== ' ') {
                beep();
            }

            await sleep(
                character === '.' ? speed * 8 :
                character === ',' ? speed * 4 :
                speed
            );

        }

    }


    // Main transmission sequence

    async function runTransmission() {

        if (running) return;

        running = true;

        receiveButton.disabled = true;
        replayButton.disabled = true;

        messagePanel.classList.add('hidden');

        messageOutput.replaceChildren();

        bootLog.innerHTML = '';

        footerStatus.textContent =
            'ACQUIRING CARRIER';


        // Boot-up messages

        const bootLines = [

            '+++ ASTROPATHIC RELAY AWAKENING +++',

            'CALIBRATING PSYCHIC RECEIVER...',

            'LOCKING ONTO TRANSMISSION SOURCE...',

            'ENCRYPTION PROTOCOL: ' +
                transmission.encryption,

            'CARRIER SIGNAL DETECTED.'

        ];


        for (const line of bootLines) {

            const p = document.createElement('p');

            p.textContent = line;

            bootLog.appendChild(p);

            await sleep(450);

        }


        // Signal acquisition

        signalLabel.textContent =
            'SIGNAL STRENGTH';


        for (let value = 0; value <= 100; value += 2) {

            signalBar.style.width = value + '%';

            signalValue.textContent =
                value + '%';

            await sleep(28);

        }


        await sleep(500);


        // Display decoded message

        bootLog.classList.add('hidden');

        messagePanel.classList.remove('hidden');

        footerStatus.textContent =
            'TRANSMISSION DECODED';


        // Type each paragraph

        for (const paragraph of transmission.message) {

            await typeText(
                messageOutput,
                paragraph,
                19
            );

            await sleep(500);

        }


        // Transmission complete

        receiveButton.disabled = false;

        replayButton.disabled = false;

        receiveButton.textContent =
            'RECEIVE AGAIN';

        running = false;

    }


    // Button events

    receiveButton.addEventListener(
        'click',
        runTransmission
    );

    replayButton.addEventListener(
        'click',
        runTransmission
    );


})();