<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scraper Status - LookForJob</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&family=JetBrains+Mono&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg-deep: #05070a;
            --bg-card: rgba(15, 23, 42, 0.6);
            --accent-primary: #3b82f6;
            /* Blue */
            --accent-secondary: #0ea5e9;
            /* Sky */
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
            overflow-x: hidden;
        }

        /* Abstract background glow */
        body::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -10%;
            width: 40%;
            height: 40%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
            z-index: -1;
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
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
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

        .icon-box {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            border-radius: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin: 0;
            letter-spacing: -0.02em;
        }

        p.subtitle {
            color: var(--text-dim);
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .output-container {
            background: #000;
            border-radius: 12px;
            padding: 20px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            line-height: 1.5;
            color: #d1d5db;
            border: 1px solid rgba(255, 255, 255, 0.05);
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 30px;
        }

        .output-container::-webkit-scrollbar {
            width: 8px;
        }

        .output-container::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            padding: 6px 16px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .status-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--success);
            border-radius: 50%;
            margin-right: 10px;
            box-shadow: 0 0 10px var(--success);
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn {
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--accent-primary);
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-main);
        }

        .btn-outline:hover {
            border-color: white;
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="icon-box">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                    </path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
            <div class="status-badge">Scraping Completed</div>
            <h1>Database Updated</h1>
            <p class="subtitle">Data from Glints, TechInAsia, and LinkedIn has been synchronized.</p>
        </div>

        <div class="output-container">
            <pre>{{ $output }}</pre>
        </div>

        <div class="btn-group">
            <a href="/scrape-now" class="btn btn-outline">Run Again</a>
            <a href="https://look-for-job.vercel.app" class="btn btn-primary">Go to Frontend</a>
        </div>
    </div>
</body>

</html>