<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $siteTitle = \App\Helpers\SettingsHelper::getSiteTitle();
        $faviconUrl = \App\Helpers\ThemeHelper::favicon();
    @endphp
    <title>Page Not Found - {{ $siteTitle }}</title>
    @if($faviconUrl)<link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">@endif
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .error-container { text-align: center; padding: 40px 20px; max-width: 700px; }
        .error-code { font-size: 140px; font-weight: 900; color: white; margin: 0; line-height: 1; text-shadow: 0 4px 20px rgba(0,0,0,0.3); animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        .error-title { font-size: 36px; font-weight: 700; color: white; margin: 30px 0 15px; }
        .error-message { font-size: 18px; color: rgba(255,255,255,0.9); margin: 0 0 40px; line-height: 1.6; }
        .action-buttons { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin: 40px 0; }
        .btn { padding: 14px 32px; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background: white; color: #667eea; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 25px rgba(0,0,0,0.3); }
        .btn-secondary { border: 2px solid white; color: white; background: transparent; }
        .btn-secondary:hover { background: white; color: #667eea; }
        .suggestions { background: white; padding: 40px; border-radius: 16px; margin-top: 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .suggestions h3 { color: #333; margin-bottom: 25px; font-size: 20px; }
        .suggestion-links { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 15px; }
        .suggestion-links a { padding: 15px; border: 2px solid #e0e0e0; border-radius: 10px; color: #667eea; text-decoration: none; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 8px; font-weight: 500; }
        .suggestion-links a i { font-size: 24px; }
        .suggestion-links a:hover { border-color: #667eea; background: #f0f4ff; transform: translateY(-4px); }
        @media (max-width: 600px) { .error-code { font-size: 90px; } .error-title { font-size: 28px; } .action-buttons { flex-direction: column; } .btn { width: 100%; justify-content: center; } }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-message">The page you're looking for doesn't exist or has been moved. Let's get you back on track!</p>

        <div class="action-buttons">
            <a href="/" class="btn btn-primary"><i class="fas fa-home"></i> Go Home</a>
            <a href="javascript:history.back()" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Go Back</a>
        </div>

        <div class="suggestions">
            <h3>Popular Pages</h3>
            <div class="suggestion-links">
                <a href="/"><i class="fas fa-home"></i> Home</a>
                <a href="/about"><i class="fas fa-info-circle"></i> About</a>
                <a href="/portfolio"><i class="fas fa-film"></i> Portfolio</a>
                <a href="/contact"><i class="fas fa-envelope"></i> Contact</a>
                <a href="/team"><i class="fas fa-users"></i> Team</a>
                <a href="/news"><i class="fas fa-newspaper"></i> News</a>
            </div>
        </div>
    </div>
</body>
</html>
