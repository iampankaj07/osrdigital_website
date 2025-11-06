<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $siteTitle = \App\Helpers\SettingsHelper::getSiteTitle();
        $faviconUrl = \App\Helpers\ThemeHelper::favicon();
    @endphp
    <title>Access Denied - {{ $siteTitle }}</title>
    @if($faviconUrl)<link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">@endif
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .error-container { text-align: center; padding: 40px 20px; max-width: 700px; }
        .error-code { font-size: 140px; font-weight: 900; color: white; margin: 0; line-height: 1; text-shadow: 0 4px 20px rgba(0,0,0,0.2); animation: pulse 2s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
        .error-title { font-size: 36px; font-weight: 700; color: white; margin: 30px 0 15px; }
        .error-message { font-size: 18px; color: rgba(255,255,255,0.95); margin: 0 0 40px; line-height: 1.6; }
        .action-buttons { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin: 40px 0; }
        .btn { padding: 14px 32px; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background: white; color: #fa709a; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 25px rgba(0,0,0,0.25); }
        .btn-secondary { border: 2px solid white; color: white; background: transparent; }
        .btn-secondary:hover { background: white; color: #fa709a; }
        .info-box { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); padding: 25px; border-radius: 12px; margin-top: 30px; border: 1px solid rgba(255,255,255,0.3); color: white; }
        .info-box p { margin: 10px 0; }
        @media (max-width: 600px) { .error-code { font-size: 90px; } .error-title { font-size: 28px; } .action-buttons { flex-direction: column; } .btn { width: 100%; justify-content: center; } }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code"><i class="fas fa-lock"></i></div>
        <h1 class="error-title">403 - Access Denied</h1>
        <p class="error-message">You don't have permission to access this resource. Please log in or contact support for assistance.</p>

        <div class="action-buttons">
            <a href="/" class="btn btn-primary"><i class="fas fa-home"></i> Go Home</a>
            <a href="/contact" class="btn btn-secondary"><i class="fas fa-envelope"></i> Contact Support</a>
        </div>

        <div class="info-box">
            <p><i class="fas fa-shield-alt"></i> This resource is restricted.</p>
            <p>If you believe this is an error, please contact our support team.</p>
        </div>
    </div>
</body>
</html>
