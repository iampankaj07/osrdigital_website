<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $siteTitle = \App\Helpers\SettingsHelper::getSiteTitle();
        $faviconUrl = \App\Helpers\ThemeHelper::favicon();
    @endphp
    <title>Maintenance - {{ $siteTitle }}</title>
    @if($faviconUrl)<link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">@endif
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .error-container { text-align: center; padding: 40px 20px; max-width: 700px; }
        .error-code { font-size: 140px; font-weight: 900; color: white; margin: 0; line-height: 1; text-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .gear { display: inline-block; animation: rotate 3s linear infinite; margin: 0 10px; }
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .error-title { font-size: 36px; font-weight: 700; color: white; margin: 30px 0 15px; }
        .error-message { font-size: 18px; color: rgba(255,255,255,0.9); margin: 0 0 40px; line-height: 1.6; }
        .progress-bar { width: 100%; height: 6px; background: rgba(255,255,255,0.2); border-radius: 3px; margin: 30px 0; overflow: hidden; }
        .progress-fill { height: 100%; background: #3498db; animation: progress 3s ease-in-out infinite; }
        @keyframes progress { 0% { width: 0%; } 50% { width: 70%; } 100% { width: 100%; } }
        .action-buttons { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin: 40px 0; }
        .btn { padding: 14px 32px; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background: #3498db; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 25px rgba(0,0,0,0.3); }
        .btn-secondary { border: 2px solid white; color: white; background: transparent; }
        .btn-secondary:hover { background: white; color: #2c3e50; }
        .info-box { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 25px; border-radius: 12px; margin-top: 30px; border: 1px solid rgba(255,255,255,0.1); color: white; }
        .info-box p { margin: 10px 0; }
        @media (max-width: 600px) { .error-code { font-size: 90px; } .error-title { font-size: 28px; } .action-buttons { flex-direction: column; } .btn { width: 100%; justify-content: center; } }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">503 <span class="gear"><i class="fas fa-cog"></i></span></div>
        <h1 class="error-title">Maintenance Mode</h1>
        <p class="error-message">We're performing scheduled maintenance to improve your experience. We'll be back online soon!</p>

        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
        <p style="color: rgba(255,255,255,0.8); margin-bottom: 30px;">Estimated time: 15-30 minutes</p>

        <div class="action-buttons">
            <a href="javascript:location.reload()" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Check Status</a>
            <a href="/contact" class="btn btn-secondary"><i class="fas fa-envelope"></i> Contact Us</a>
        </div>

        <div class="info-box">
            <p><i class="fas fa-tools"></i> System Update in Progress</p>
            <p>Thank you for your patience. We'll be back soon!</p>
        </div>
    </div>
</body>
</html>
