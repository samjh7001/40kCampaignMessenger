<?php
// Astropathic Relay - starter terminal
// Run locally with: php -S localhost:8000

$themes = [
    'blood_angels',
    'dark_angels',
    'tyranids',
    'orks',
    'mechanicus',
    'imperial_guard'
];

$theme = $_GET['faction'] ?? 'blood_angels';

if (!in_array($theme, $themes, true)) {
    $theme = 'blood_angels';
}

// Demo transmission only.
// Private-link token validation will be added with the backend.

$transmission = [
    'id' => 'BA-001',
    'recipient' => 'Sergeant Lorenzo',
    'faction' => $theme,
    'sender' => 'Astropathic Choir, Sagittarius Arm',
    'classification' => 'RESTRICTED',
    'encryption' => 'SIGMA',
    'relay' => 'Sagittarius Arm',
    'location' => 'Osow, the feudal world',
    'verification' => 'Unverified',
    'subject' => 'Priority communication',
    'message' => [
        'Humanity is in danger.',
        'Xenos activity has been detected on Osow. Local authorities are believed to have been compromised by a Genestealer cult. Imperial law has collapsed across several settlements.',
        'Your orders are to verify this transmission, assess the threat, and ensure the protection of Imperial citizens where possible.',
        'For the Emperor and Sanguinius.'
    ]
];

$labels = [
    'blood_angels' => 'Blood Angels',
    'dark_angels' => 'Dark Angels',
    'tyranids' => 'Tyranid Bio-Signal',
    'orks' => 'Ork Scrap-Relay',
    'mechanicus' => 'Adeptus Mechanicus',
    'imperial_guard' => 'Astra Militarum'
];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="theme-color" content="#06110b">

    <title>
        Astropathic Relay // Incoming Transmission
    </title>

    <link rel="stylesheet" href="assets/css/terminal.css">
</head>

<body class="theme-<?= htmlspecialchars($theme, ENT_QUOTES, 'UTF-8') ?>">

<main class="terminal-shell">

    <div class="terminal-topbar">

        <span class="rec-dot"></span>

        <span>IMPERIAL ASTROPATHIC RELAY</span>

        <span class="topbar-right">
            NODE: SAG-09 //
            <span id="clock">--:--:--</span>
        </span>

    </div>


    <section class="terminal-screen" aria-live="polite">

        <div class="scanlines"></div>
        <div class="noise"></div>


        <header class="screen-header">

            <div>

                <p class="eyebrow">
                    +++ INCOMING TRANSMISSION +++
                </p>

                <h1 id="terminal-title">
                    ASTROPATHIC COMMUNICATIONS TERMINAL
                </h1>

                <p class="subheading">
                    RECIPIENT:
                    <?= htmlspecialchars($labels[$theme], ENT_QUOTES, 'UTF-8') ?>
                </p>

            </div>

            <div class="aquila-mark" aria-label="Imperial seal">
                ✠
            </div>

        </header>


        <div class="status-grid">

            <div>
                <span>RELAY</span>
                <strong>
                    <?= htmlspecialchars($transmission['relay']) ?>
                </strong>
            </div>

            <div>
                <span>ENCRYPTION</span>
                <strong>
                    <?= htmlspecialchars($transmission['encryption']) ?>
                </strong>
            </div>

            <div>
                <span>CLASSIFICATION</span>
                <strong class="classification">
                    <?= htmlspecialchars($transmission['classification']) ?>
                </strong>
            </div>

        </div>


        <div class="signal-row">

            <span id="signal-label">
                ACQUIRING SIGNAL
            </span>

            <div class="signal-track">
                <div id="signal-bar"></div>
            </div>

            <strong id="signal-value">0%</strong>

        </div>


        <div id="boot-log" class="boot-log">

            <p>+++ RELAY STANDBY +++</p>

            <p>AWAITING ASTROPATHIC CARRIER...</p>

        </div>


        <article id="message-panel" class="message-panel hidden">

            <div class="message-meta">

                <p>
                    FROM:
                    <?= htmlspecialchars($transmission['sender']) ?>
                </p>

                <p>
                    TO:
                    <?= htmlspecialchars($transmission['recipient']) ?>
                </p>

                <p>
                    LOCATION:
                    <?= htmlspecialchars($transmission['location']) ?>
                </p>

                <p>
                    VERIFICATION:
                    <?= htmlspecialchars($transmission['verification']) ?>
                </p>

            </div>


            <div class="message-rule">
                +++ MESSAGE BEGINS +++
            </div>


            <h2>
                <?= htmlspecialchars($transmission['subject']) ?>
            </h2>


            <div id="message-output" class="message-output"></div>


            <p class="message-signoff">
                +++ THE EMPEROR PROTECTS +++
            </p>


            <div class="message-rule">
                +++ END OF TRANSMISSION +++
            </div>

        </article>


        <footer class="screen-footer">

            <span>
                SEGMENTUM OBSCURUS // IMPERIAL NETWORK
            </span>

            <span id="footer-status">
                AWAITING CONNECTION
            </span>

        </footer>

    </section>


    <div class="terminal-controls">

        <button id="receive-button" type="button">
            INITIATE RECEPTION
        </button>

        <button id="replay-button" type="button" disabled>
            REPLAY TRANSMISSION
        </button>

        <label class="sound-toggle">
            <input id="sound-toggle" type="checkbox">
            AUDIO
        </label>

        <span class="faction-label">
            THEME:
            <?= htmlspecialchars($labels[$theme], ENT_QUOTES, 'UTF-8') ?>
        </span>

    </div>


    <p class="disclaimer">
        UNAUTHORISED ACCESS IS PUNISHABLE UNDER IMPERIAL LAW.
    </p>

</main>


<script>

window.RELAY_TRANSMISSION = <?= json_encode(
    $transmission,
    JSON_HEX_TAG |
    JSON_HEX_APOS |
    JSON_HEX_AMP |
    JSON_HEX_QUOT
) ?>;

</script>


<script src="assets/js/terminal.js"></script>

</body>
</html>