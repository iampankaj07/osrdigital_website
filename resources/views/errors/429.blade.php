<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $siteTitle = \App\Helpers\SettingsHelper::getSiteTitle();
        $faviconUrl = \App\Helpers\ThemeHelper::favicon();
    @endphp
    <title>Too Many Requests - {{ $siteTitle }}</title>
    @if($faviconUrl)<link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">@endif
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .error-container { text-align: center; padding: 40px 20px; max-width: 700px; }
        .error-code { font-size: 140px; font-weight: 900; color: white; margin: 0; line-height: 1; text-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .error-title { font-size: 36px; font-weight: 700; color: white; margin: 30px 0 15px; }
        .error-message { font-size: 18px; color: rgba(255,255,255,0.9); margin: 0 0 40px; line-height: 1.6; }
        .countdown { font-size: 48px; font-weight: 900; color: white; margin: 30px 0; animation: bounce 1s ease-in-out infinite; }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .action-buttons { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin: 40px 0; }
        .btn { padding: 14px 32px; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background: white; color: #667eea; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .btn-primary:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 6px 25px rgba(0,0,0,0.3); }
        .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }
        .btn-secondary { border: 2px solid white; color: white; background: transparent; }
        .btn-secondary:hover { background: white; color: #667eea; }
        .info-box { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 25px; border-radius: 12px; margin-top: 30px; border: 1px solid rgba(255,255,255,0.2); color: white; }
        .info-box p { margin: 10px 0; }
        @media (max-width: 600px) { .error-code { font-size: 90px; } .error-title { font-size: 28px; } .action-buttons { flex-direction: column; } .btn { width: 100%; justify-content: center; } }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code"><i class="fas fa-hourglass-end"></i></div>
        <h1 class="error-title">429 - Rate Limited</h1>
        <p class="error-message">You've made too many requests. Please wait a moment before trying again.</p>

        <div class="countdown">
            <span id="timer">60</span>s
        </div>

        <div class="action-buttons">
            <button id="retry-btn" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Try Again (<span id="retry-timer">60</span>s)</button>
            <a href="/" class="btn btn-secondary"><i class="fas fa-home"></i> Go Home</a>
        </div>

        <div class="info-box">
            <p><i class="fas fa-info-circle"></i> Please wait before making more requests.</p>
            <p>The button will become available when you can retry.</p>
        </div>
    </div>

    <script>
        let seconds = 60;
        const timerEl = document.getElementById('timer');
        const retryBtn = document.getElementById('retry-btn');
        const retryTimerEl = document.getElementById('retry-timer');

        const interval = setInterval(() => {
            seconds--;
            timerEl.textContent = seconds;
            retryTimerEl.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(interval);
                retryBtn.disabled = false;
                retryBtn.textContent = '✓ Try Again';
            }
        }, 1000);

        retryBtn.addEventListener('click', () => location.reload());
    </script>
</body>
</html>
