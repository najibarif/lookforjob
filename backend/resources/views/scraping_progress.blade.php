<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scraping Jobs - Please Wait</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&family=JetBrains+Mono&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg-deep: #05070a;
            --accent-primary: #3b82f6;
            --accent-secondary: #0ea5e9;
            --text-main: #f8fafc;
        }

        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .loader-container {
            text-align: center;
            position: relative;
        }

        /* The Animated Radar/Scanner */
        .scanner {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 2px solid rgba(59, 130, 246, 0.2);
            position: relative;
            margin: 0 auto 40px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.05) 0%, transparent 70%);
        }

        .scanner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: conic-gradient(from 0deg, var(--accent-primary) 0%, transparent 40%);
            border-radius: 50%;
            animation: scan 2s linear infinite;
        }

        @keyframes scan {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .pulse {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: var(--accent-secondary);
            border-radius: 50%;
            box-shadow: 0 0 20px var(--accent-secondary);
            animation: pulse-glow 1.5s infinite alternate;
        }

        @keyframes pulse-glow {
            from {
                box-shadow: 0 0 10px var(--accent-secondary);
                transform: translate(-50%, -50%) scale(0.9);
            }

            to {
                box-shadow: 0 0 30px var(--accent-primary);
                transform: translate(-50%, -50%) scale(1.1);
            }
        }

        h1 {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 1.8rem;
        }

        .status-text {
            color: var(--accent-secondary);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
        }

        .progress-bar-container {
            width: 300px;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            margin: 20px auto;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
            box-shadow: 0 0 10px var(--accent-primary);
            transition: width 0.5s ease;
        }

        .tip {
            margin-top: 40px;
            font-size: 0.8rem;
            color: #475569;
            max-width: 300px;
        }
    </style>
</head>

<body>
    <div class="loader-container">
        <div class="scanner">
            <div class="pulse"></div>
        </div>
        <h1>Initializing Search</h1>
        <div class="status-text" id="status">Connecting to LinkedIn...</div>

        <div class="progress-bar-container">
            <div class="progress-fill" id="progress"></div>
        </div>

        <div class="tip">Searching across Glints, TechInAsia, and LinkedIn for the latest opportunities.</div>
    </div>

    <script>
        const statusEl = document.getElementById('status');
        const progressEl = document.getElementById('progress');
        const messages = [
            'Synching with Glints API...',
            'Crawling TechInAsia postings...',
            'Gathering LinkedIn connections...',
            'Filtering duplicates...',
            'Optimizing database entries...',
            'Synthesizing results...'
        ];

        let i = 0;
        const interval = setInterval(() => {
            statusEl.innerText = messages[i % messages.length];
            progressEl.style.width = ((i + 1) * 15) + '%';
            i++;
            if (i > messages.length) i = messages.length;
        }, 2500);

        // Actual AJAX call to trigger the scrape
        fetch('/api/internal-scrape')
            .then(res => res.text())
            .then(html => {
                document.open();
                document.write(html);
                document.close();
            })
            .catch(err => {
                statusEl.innerText = 'Error occurred. Retrying...';
                statusEl.style.color = '#ef4444';
            });
    </script>
</body>

</html>