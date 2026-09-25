<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found | Kashif Khan Portfolio</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <style>
        :root {
            --bg: #09090b;
            --card: #18181b;
            --border: #27272a;
            --text-primary: #fafafa;
            --text-secondary: #a1a1aa;
            --accent: #6366f1;
            --muted: #1e1e24;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient subtle radial glow */
        .ambient-glow {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 450px;
            background: radial-gradient(circle at top, rgba(99, 102, 241, 0.18) 0%, rgba(168, 85, 247, 0.08) 40%, transparent 70%);
            pointer-events: none;
            filter: blur(60px);
        }

        .grid-pattern {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 28px 28px;
            mask-image: radial-gradient(ellipse 60% 50% at 50% 30%, #000 70%, transparent 100%);
            pointer-events: none;
        }

        header {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: inherit;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #fff;
            color: #09090b;
            font-weight: 800;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-text {
            font-weight: 700;
            font-size: 14px;
            letter-spacing: -0.02em;
        }

        main {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .container {
            max-width: 600px;
            text-align: center;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 14px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border);
            font-size: 12px;
            font-family: monospace;
            color: var(--text-secondary);
            margin-bottom: 24px;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #f43f5e;
            box-shadow: 0 0 10px #f43f5e;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.85); }
        }

        .error-code {
            font-size: clamp(6rem, 16vw, 10rem);
            font-weight: 900;
            letter-spacing: -0.05em;
            line-height: 1;
            background: linear-gradient(180deg, #fafafa 30%, rgba(250, 250, 250, 0.2) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .title {
            font-size: clamp(1.4rem, 4vw, 1.85rem);
            font-weight: 800;
            letter-spacing: -0.025em;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .description {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 32px;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 48px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 6px;
            background: #fafafa;
            color: #09090b;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:hover {
            background: #e4e4e7;
            transform: translateY(-1px);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 6px;
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border);
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: #3f3f46;
        }

        .cards-grid {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 32px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 12px;
            text-align: left;
        }

        .card {
            padding: 14px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: rgba(24, 24, 27, 0.5);
            text-decoration: none;
            color: inherit;
            transition: all 0.2s ease;
        }

        .card:hover {
            background: rgba(39, 39, 42, 0.6);
            border-color: #3f3f46;
            transform: translateY(-2px);
        }

        .card-title {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--text-primary);
        }

        .card-desc {
            font-size: 11px;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        footer {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-secondary);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>
    <div class="grid-pattern"></div>

    <header>
        <a href="/" class="brand">
            <div class="avatar">KK</div>
            <span class="brand-text">Kashif Khan Dev</span>
        </a>
        <a href="/" class="btn-outline" style="font-size: 12px; padding: 6px 14px;">Portfolio Home ↗</a>
    </header>

    <main>
        <div class="container">
            <div class="badge">
                <span class="dot"></span>
                <span>Error 404</span>
                <span style="opacity: 0.3;">|</span>
                <span>Destination Not Found</span>
            </div>

            <div class="error-code">404</div>
            <h1 class="title">This page has been relocated or removed</h1>
            <p class="description">
                The resource, section, or page you are looking for doesn't exist or was decommissioned.
            </p>

            <div class="actions">
                <button onclick="window.history.back()" class="btn-outline">
                    ← Go Back
                </button>
                <a href="/admin/dashboard" class="btn-primary">
                    Return to Dashboard
                </a>
            </div>

            <div class="cards-grid">
                <a href="/admin/dashboard" class="card">
                    <div class="card-title">Admin Dashboard →</div>
                    <div class="card-desc">Overview & portfolio management</div>
                </a>
                <a href="/projects" class="card">
                    <div class="card-title">Projects Archive →</div>
                    <div class="card-desc">Showcase of software builds</div>
                </a>
                <a href="/blog" class="card">
                    <div class="card-title">Articles & Blog →</div>
                    <div class="card-desc">Engineering writeups & guides</div>
                </a>
            </div>
        </div>
    </main>

    <footer>
        <div>© <?php echo date('Y'); ?> Kashif Khan. All rights reserved.</div>
        <div style="font-family: monospace; font-size: 11px;">Status: 404 NOT_FOUND</div>
    </footer>
</body>
</html>
