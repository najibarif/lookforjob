<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sync Complete - LookForJob</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&family=JetBrains+Mono&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg-deep: #05070a;
            --bg-card: rgba(15, 23, 42, 0.6);
            --accent-primary: #3b82f6;
            --accent-secondary: #0ea5e9;
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
            --success: #10b981;
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
        }

        .container {
            width: 90%;
            max-width: 800px;
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .success-icon {
            width: 60px;
            height: 60px;
            background: var(--success);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.3);
        }

        h1 {
            font-weight: 600;
            margin: 0;
        }

        .subtitle {
            color: var(--text-dim);
            margin-top: 10px;
        }

        .output-box {
            background: #000;
            border-radius: 16px;
            padding: 25px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            color: #94a3b8;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin: 25px 0;
            overflow-x: auto;
        }

        .output-box b {
            color: var(--accent-secondary);
        }

        .footer-btns {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn {
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary {
            background: var(--accent-primary);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-outline {
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <h1>Sync Complete</h1>
            <p class="subtitle">Database successfully refreshed with live job data.</p>
        </div>

        <div class="output-box">
            <pre>{!! preg_replace('/(✅|❌|🚀|📊|📈)/', '<b>$1</b>', $output) !!}</pre>
        </div>

        <div class="footer-btns">
            <a href="/scrape-now" class="btn btn-outline">Resync Now</a>
            <a href="https://look-for-job.vercel.app" class="btn btn-primary">Check Results</a>
        </div>
    </div>
</body>

</html>